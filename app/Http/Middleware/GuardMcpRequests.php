<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Premières barrières du serveur MCP, avant même l'authentification.
 *
 * - Origin : la spécification MCP impose de le vérifier, contre le DNS
 *   rebinding. Un client MCP (IDE, CLI, serveur) n'envoie pas d'Origin ; un
 *   navigateur, si. Seule l'origine du site est acceptée.
 * - Taille : un appel d'outil tient en quelques centaines d'octets. Un corps
 *   énorme n'est jamais légitime et coûte du décodage JSON pour rien.
 */
class GuardMcpRequests
{
    public const MAX_BODY_BYTES = 64 * 1024;

    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('Origin');

        if ($origin !== null && ! $this->isAllowedOrigin($origin)) {
            return $this->reject('Origin not allowed.', 403);
        }

        $length = (int) $request->headers->get('Content-Length', '0');

        if ($length > self::MAX_BODY_BYTES || strlen($request->getContent()) > self::MAX_BODY_BYTES) {
            return $this->reject('Request body too large.', 413);
        }

        return $next($request);
    }

    private function isAllowedOrigin(string $origin): bool
    {
        $allowed = parse_url((string) config('app.url'));
        $given = parse_url($origin);

        if (! is_array($allowed) || ! is_array($given)) {
            return false;
        }

        return ($given['scheme'] ?? null) === ($allowed['scheme'] ?? null)
            && ($given['host'] ?? null) === ($allowed['host'] ?? null)
            && ($given['port'] ?? null) === ($allowed['port'] ?? null);
    }

    private function reject(string $message, int $status): JsonResponse
    {
        // Forme JSON-RPC : le client MCP affiche le message au lieu d'un
        // simple code HTTP.
        return response()->json([
            'jsonrpc' => '2.0',
            'id' => null,
            'error' => ['code' => -32600, 'message' => $message],
        ], $status);
    }
}
