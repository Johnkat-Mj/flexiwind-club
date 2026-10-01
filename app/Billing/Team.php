<?php

namespace App\Billing;

use App\Mail\TeamInvitationMail;
use App\Models\Invitation;
use App\Models\Subscription;
use App\Models\SubscriptionMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Gestion des sièges d'un abonnement d'équipe.
 *
 * Chaque siège est un compte à part entière : son propre lien de connexion,
 * ses propres jetons. Le propriétaire peut libérer un siège, ce qui révoque
 * aussitôt les jetons de la personne concernée.
 */
final class Team
{
    /** Invitations qu'un propriétaire peut envoyer par heure : notre serveur de mail n'est pas un relais. */
    private const INVITES_PER_HOUR = 20;

    public function invite(Subscription $subscription, User $inviter, string $email): Invitation
    {
        $email = Str::lower(trim($email));

        if (! $subscription->isOwnedBy($inviter)) {
            throw new RuntimeException('Only the subscription owner can invite.');
        }

        if (! $subscription->isActive()) {
            throw new RuntimeException('This subscription is not active.');
        }

        $rateKey = 'team-invites:'.$inviter->id;

        if (RateLimiter::tooManyAttempts($rateKey, self::INVITES_PER_HOUR)) {
            throw new RuntimeException('Too many invitations sent in the last hour. Try again later.');
        }

        $invitation = DB::transaction(function () use ($subscription, $inviter, $email): Invitation {
            // Verrou sur la ligne d'abonnement : deux invitations envoyées au
            // même instant ne peuvent pas prendre le même dernier siège.
            Subscription::query()->whereKey($subscription->id)->lockForUpdate()->first();

            if ($subscription->members()->where('email', $email)->exists()) {
                throw new RuntimeException('That person already holds a seat.');
            }

            if ($subscription->pendingInvitations()->where('email', $email)->exists()) {
                throw new RuntimeException('An invitation is already pending for that address.');
            }

            if (! $subscription->hasSeatAvailable()) {
                throw new RuntimeException('No seat left. Free one up first.');
            }

            return Invitation::issue($subscription, $inviter, $email);
        });

        RateLimiter::hit($rateKey, 3600);

        Mail::to($email)->send(new TeamInvitationMail(
            url: $this->acceptUrl($invitation),
            inviterName: $inviter->name,
            planName: $subscription->planName(),
        ));

        return $invitation;
    }

    public function acceptUrl(Invitation $invitation): string
    {
        return URL::temporarySignedRoute(
            'team.invitation',
            $invitation->expires_at,
            ['invitation' => $invitation->getKey(), 'token' => $invitation->plainToken],
        );
    }

    /**
     * Installe le compte connecté sur le siège.
     *
     * L'invitation est nominative : elle ne peut être acceptée que par
     * l'adresse à laquelle elle a été envoyée, sinon un lien transféré
     * ouvrirait le siège à n'importe qui.
     */
    public function accept(Invitation $invitation, User $user): void
    {
        if (! hash_equals($invitation->email, Str::lower($user->email))) {
            throw new RuntimeException('This invitation was sent to another address.');
        }

        $subscription = $invitation->subscription;

        if (! $subscription->isActive()) {
            throw new RuntimeException('This subscription is no longer active.');
        }

        DB::transaction(function () use ($invitation, $subscription, $user): void {
            // Recompte les sièges dans la transaction, ligne verrouillée : deux
            // personnes qui acceptent en même temps ne dépassent pas la limite.
            Subscription::query()->whereKey($subscription->id)->lockForUpdate()->first();

            if ($subscription->members()->whereKey($user->id)->exists()) {
                $invitation->forceFill(['accepted_at' => now()])->save();

                return;
            }

            if ($subscription->members()->count() >= $subscription->seats) {
                throw new RuntimeException('No seat left on this subscription.');
            }

            $subscription->members()->syncWithoutDetaching([
                $user->id => [
                    'role' => SubscriptionMember::ROLE_MEMBER,
                    'joined_at' => now(),
                ],
            ]);

            $invitation->forceFill(['accepted_at' => now()])->save();
        });
    }

    /** Libère un siège et coupe l'accès de la personne dans la foulée. */
    public function removeMember(Subscription $subscription, User $owner, int $userId): void
    {
        if (! $subscription->isOwnedBy($owner)) {
            throw new RuntimeException('Only the subscription owner can remove a member.');
        }

        if ($userId === $subscription->owner_id) {
            throw new RuntimeException('The owner keeps their own seat.');
        }

        DB::transaction(function () use ($subscription, $userId): void {
            $subscription->members()->detach($userId);

            // Sans siège, les jetons de cette personne n'ont plus de raison
            // d'exister : on les révoque au lieu d'attendre le prochain appel.
            User::find($userId)?->apiTokens()->active()->update(['revoked_at' => now()]);
        });
    }
}
