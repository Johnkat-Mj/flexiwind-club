<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Registry\ProRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Le registre `@fx` de la CLI.
 *
 * Dans le flexiwind.yaml du projet :
 *
 *     registries:
 *       '@fx':
 *         url: https://flexiwind.dev/api/v1/pro/{name}
 *         headers:
 *           Authorization: 'Bearer ${FLEXIWIND_TOKEN}'
 *
 * `php artisan flexi:add @fx/login01` appelle alors /api/v1/pro/login01 :
 * la CLI retire le préfixe du nom, c'est l'URL qui porte le palier.
 */
class ProRegistryController extends Controller
{
    public function __construct(private readonly ProRegistry $registry) {}

    public function index(Request $request): JsonResponse
    {
        if ($denied = $this->denyWithoutSubscription($request)) {
            return $denied;
        }

        return $this->private(response()->json([
            'name' => '@fx',
            'homepage' => url('/blocks'),
            'items' => $this->registry->index(),
        ]));
    }

    public function show(Request $request, string $name): JsonResponse
    {
        $name = strtolower(preg_replace('/\.json$/', '', $name));

        // Le contrôle d'accès passe AVANT la recherche : sans abonnement, un
        // nom existant et un nom inventé reçoivent la même réponse.
        if ($denied = $this->denyWithoutSubscription($request)) {
            return $denied;
        }

        $payload = $this->registry->find($name);

        if ($payload === null) {
            return response()->json(['message' => "Unknown Pro component [@fx/{$name}]."], 404);
        }

        $this->registry->recordDownload(
            $request->user(),
            $request->attributes->get('api_token'),
            $name,
            $request->ip(),
        );

        return $this->private(response()->json($payload));
    }

    private function denyWithoutSubscription(Request $request): ?JsonResponse
    {
        if ($request->user()->hasProAccess()) {
            return null;
        }

        return response()->json([
            'message' => 'This component is part of Flexiwind Pro, and no active subscription covers this account.',
            'upgrade_url' => route('pricing'),
        ], 403);
    }

    /** Une source payante ne doit rester dans aucun cache partagé. */
    private function private(JsonResponse $response): JsonResponse
    {
        return $response->withHeaders(['Cache-Control' => 'private, no-store, max-age=0']);
    }
}
