<?php

namespace App\Http\Controllers;

use App\Billing\Team;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

/**
 * Le lien reçu par mail n'accepte rien par lui-même : il affiche
 * l'invitation, et c'est un POST protégé par CSRF qui occupe le siège. Un
 * scanner de mails ou un aperçu de lien qui suit l'URL ne change donc rien.
 */
class TeamInvitationController extends Controller
{
    public function __construct(private readonly Team $team) {}

    public function show(Request $request, int $invitation, string $token): View|RedirectResponse
    {
        $model = $this->findPending($invitation, $token);

        if ($model === null) {
            return $this->invalid();
        }

        $user = $request->user();

        return view('pages.team-invitation', [
            'invitation' => $model,
            'inviter' => $model->inviter,
            'planName' => $model->subscription->planName(),
            'user' => $user,
            'matchesInvitedAddress' => $user !== null && hash_equals($model->email, strtolower($user->email)),
        ]);
    }

    public function accept(Request $request, int $invitation, string $token): RedirectResponse
    {
        $model = $this->findPending($invitation, $token);

        if ($model === null) {
            return $this->invalid();
        }

        if (! Auth::check()) {
            // On garde le lien complet : la personne y revient une fois
            // connectée avec l'adresse invitée.
            $request->session()->put('url.intended', $request->fullUrl());

            // L'adresse passe par la session, pas par l'URL : elle ne finit ni
            // dans l'historique, ni dans les logs d'accès.
            return redirect()->route('login')->with([
                'login.email' => $model->email,
                'status.info' => 'Sign in with '.$model->email.' to claim your seat.',
            ]);
        }

        try {
            $this->team->accept($model, $request->user());
        } catch (RuntimeException $e) {
            return redirect()->route('account')->with('status.error', $e->getMessage());
        }

        return redirect()->route('account.subscription')
            ->with('status.sent', 'Your seat is active. Generate a token to use the CLI.');
    }

    private function findPending(int $invitation, string $token): ?Invitation
    {
        $model = Invitation::query()
            ->whereKey($invitation)
            ->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        return $model !== null && hash_equals($model->token_hash, hash('sha256', $token)) ? $model : null;
    }

    private function invalid(): RedirectResponse
    {
        return redirect()->route('login')->with(
            'status.error',
            'That invitation is no longer valid. Ask for a new one.',
        );
    }
}
