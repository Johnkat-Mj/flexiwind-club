<?php

namespace App\Billing;

use App\Models\Subscription;
use App\Models\SubscriptionMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Création et activation d'un abonnement.
 *
 * Point important pour la sécurité : rien de ce qui a une valeur (prix,
 * sièges, durée) ne vient de la requête. L'appelant fournit un objet Plan,
 * qui n'a pu être obtenu que par Plan::find() sur le catalogue en config.
 */
final class Checkout
{
    /** Ouvre un abonnement en attente de paiement. */
    public function start(User $user, Plan $plan): Subscription
    {
        if ($user->hasProAccess()) {
            throw new RuntimeException('This account already has an active subscription.');
        }

        return DB::transaction(function () use ($user, $plan): Subscription {
            $subscription = new Subscription;

            $subscription->forceFill([
                'owner_id' => $user->id,
                'plan_key' => $plan->key,
                'seats' => $plan->seats,
                'status' => Subscription::STATUS_PENDING,
                'amount_cents' => $plan->priceCents,
                'currency' => $plan->currency,
                'provider' => config('billing.simulate') ? 'simulated' : 'pending',
            ])->save();

            return $subscription;
        });
    }

    /**
     * Marque l'abonnement payé et installe le propriétaire sur son siège.
     *
     * Idempotent : rejouer la même référence (webhook livré deux fois) ne
     * crée pas un second abonnement et ne prolonge rien.
     */
    public function markPaid(Subscription $subscription, string $reference, string $provider = 'simulated'): Subscription
    {
        if ($subscription->paid_at !== null) {
            return $subscription;
        }

        $plan = $subscription->plan();

        if ($plan === null) {
            throw new RuntimeException("Unknown plan [{$subscription->plan_key}].");
        }

        return DB::transaction(function () use ($subscription, $plan, $reference, $provider): Subscription {
            $startsAt = now();

            $subscription->forceFill([
                'status' => Subscription::STATUS_ACTIVE,
                'starts_at' => $startsAt,
                'ends_at' => $plan->endsAtFrom($startsAt),
                // Le montant est relu du catalogue, pas conservé tel quel :
                // si le prix a changé entre l'ouverture et le paiement, c'est
                // le catalogue qui fait foi.
                'amount_cents' => $plan->priceCents,
                'currency' => $plan->currency,
                'seats' => $plan->seats,
                'provider' => $provider,
                'provider_reference' => $reference,
                'paid_at' => now(),
            ])->save();

            $subscription->members()->syncWithoutDetaching([
                $subscription->owner_id => [
                    'role' => SubscriptionMember::ROLE_OWNER,
                    'joined_at' => now(),
                ],
            ]);

            return $subscription->refresh();
        });
    }

    /** Référence de transaction factice, unique, reconnaissable dans les logs. */
    public function simulatedReference(): string
    {
        return 'sim_'.Str::lower(Str::random(24));
    }
}
