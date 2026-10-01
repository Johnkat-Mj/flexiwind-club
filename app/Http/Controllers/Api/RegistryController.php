<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Flexiwind\Docs\BlockRegistry;
use Flexiwind\Docs\Tier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Ancienne adresse du registre, gardée pour les configurations existantes.
 *
 * `/registry/header01`      -> palier free
 * `/registry/@fx/header01`  -> palier pro, confié à ProRegistryController
 */
class RegistryController extends Controller
{
    public function __invoke(Request $request, BlockRegistry $registry, string $name): JsonResponse
    {
        if (str_starts_with($name, '@fx/')) {
            return app(ProRegistryController::class)->show($request, substr($name, 4));
        }

        // Un nom ne peut désigner qu'un fichier de payload : pas de traversée
        // de répertoire, pas de chemin absolu.
        if (preg_match('/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/', $name) !== 1) {
            return response()->json(['message' => 'Invalid component name.'], 422);
        }

        $payload = $registry->find($name, Tier::Free);

        if ($payload === null) {
            return response()->json(['message' => "Unknown component [{$name}]."], 404);
        }

        return response()->json($payload);
    }
}
