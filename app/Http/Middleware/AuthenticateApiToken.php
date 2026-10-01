<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authentifie un appel de la CLI à partir d'un jeton porteur.
 *
 * Le jeton seul ne donne rien : il identifie une personne, et c'est
 * l'abonnement de cette personne — vérifié ici à chaque appel — qui décide
 * de l'accès. Révoquer un siège coupe donc l'accès immédiatement, sans
 * attendre l'expiration d'un jeton (les jetons n'expirent pas).
 */
class AuthenticateApiToken
{
    /** Jetons refusés tolérés par IP et par fenêtre, avant de couper. */
    private const MAX_FAILURES = 10;

    private const FAILURE_WINDOW_SECONDS = 600;

    public function handle(Request $request, Closure $next): Response
    {
        // Le secret fait 48 caractères aléatoires : le deviner est hors de
        // portée. Ce compteur coupe surtout le bruit d'un script qui essaie
        // une liste de jetons fuités.
        $failureKey = 'cli-auth-failures:'.$request->ip();

        if (RateLimiter::tooManyAttempts($failureKey, self::MAX_FAILURES)) {
            return response()->json([
                'message' => 'Too many invalid tokens from this address. Try again later.',
            ], 429, ['Retry-After' => (string) RateLimiter::availableIn($failureKey)]);
        }

        $secret = $request->bearerToken();

        if ($secret === null || $secret === '') {
            return $this->unauthorized('Missing token. Generate one at '.route('account.tokens').'.');
        }

        $token = strlen($secret) <= 128 ? ApiToken::findActive($secret) : null;

        if ($token === null) {
            RateLimiter::hit($failureKey, self::FAILURE_WINDOW_SECONDS);

            return $this->unauthorized('Unknown or revoked token.');
        }

        $token->markUsed($request->ip());

        $request->setUserResolver(fn () => $token->user);
        // Le serveur MCP lit l'utilisateur sur le guard, pas sur la requête.
        // setUser() n'ouvre aucune session : rien n'est écrit en cookie.
        Auth::setUser($token->user);
        $request->attributes->set('api_token', $token);

        return $next($request);
    }

    private function unauthorized(string $message): JsonResponse
    {
        return response()->json(['message' => $message], 401, ['WWW-Authenticate' => 'Bearer']);
    }
}
