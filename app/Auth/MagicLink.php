<?php

namespace App\Auth;

use App\Mail\MagicLinkMail;
use App\Models\LoginLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * Connexion par lien à usage unique.
 *
 * Le même parcours sert à créer un compte et à se reconnecter : la page de
 * connexion ne peut donc pas servir à savoir si une adresse est inscrite.
 * La réponse est identique dans tous les cas, y compris quand on n'envoie
 * rien.
 */
final class MagicLink
{
    /** Demandes autorisées pour une même adresse, par fenêtre. */
    private const PER_EMAIL = 3;

    /** Demandes autorisées depuis une même IP, par fenêtre. */
    private const PER_IP = 10;

    private const WINDOW_SECONDS = 600;

    public function request(string $email, Request $request): MagicLinkStatus
    {
        $email = Str::lower(trim($email));

        // Deux compteurs : l'un protège une boîte mail du harcèlement,
        // l'autre empêche un script de balayer des milliers d'adresses.
        $emailKey = 'magic-link:email:'.hash('sha256', $email);
        $ipKey = 'magic-link:ip:'.$request->ip();

        if (RateLimiter::tooManyAttempts($emailKey, self::PER_EMAIL)
            || RateLimiter::tooManyAttempts($ipKey, self::PER_IP)) {
            return MagicLinkStatus::Throttled;
        }

        RateLimiter::hit($emailKey, self::WINDOW_SECONDS);
        RateLimiter::hit($ipKey, self::WINDOW_SECONDS);

        $link = LoginLink::issue($email, $request->ip(), $request->userAgent());
        $url = $this->url($link);

        Mail::to($email)->send(new MagicLinkMail(
            url: $url,
            isNewAccount: ! User::where('email', $email)->exists(),
        ));

        $this->logForDevelopers($email, $url);

        return MagicLinkStatus::Sent;
    }

    /**
     * Hors production, écrit l'URL en clair dans le log.
     *
     * Le corps du mail y est déjà, mais sous forme de HTML : le href y porte
     * `&amp;`, et copié tel quel le navigateur envoie un paramètre
     * `amp;signature`, donc plus de `signature` — d'où un 403. Cette ligne
     * donne une URL cliquable telle quelle.
     */
    private function logForDevelopers(string $email, string $url): void
    {
        if (app()->isProduction()) {
            return;
        }

        Log::info("Magic link for {$email}: {$url}");
    }

    /**
     * URL signée : l'identifiant et le secret voyagent dans le chemin, jamais
     * l'adresse mail. La signature est une seconde barrière — le secret reste
     * la vraie preuve.
     */
    public function url(LoginLink $link): string
    {
        return URL::temporarySignedRoute(
            'auth.link',
            $link->expires_at,
            ['link' => $link->getKey(), 'token' => $link->plainToken],
        );
    }

    /**
     * Consomme un lien et ouvre la session. Retourne null si le lien est
     * invalide, expiré ou déjà utilisé.
     */
    public function consume(int $linkId, string $token, Request $request): ?User
    {
        $link = LoginLink::query()
            ->whereKey($linkId)
            ->whereNull('consumed_at')
            ->where('expires_at', '>', now())
            ->first();

        // hash_equals : comparaison à temps constant, même si le secret
        // aléatoire rend l'attaque temporelle théorique.
        if ($link === null || ! hash_equals($link->token_hash, hash('sha256', $token))) {
            return null;
        }

        $link->consume();

        $user = User::firstOrCreate(
            ['email' => $link->email],
            ['name' => Str::before($link->email, '@')],
        );

        if ($user->email_verified_at === null) {
            // Cliquer le lien prouve la possession de la boîte mail.
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return $user;
    }
}
