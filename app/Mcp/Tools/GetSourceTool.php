<?php

namespace App\Mcp\Tools;

use App\Mcp\Concerns\ValidatesCatalogReference;
use App\Models\ApiToken;
use App\Models\RegistryDownload;
use App\Registry\Catalog;
use App\Registry\ProRegistry;
use Flexiwind\Docs\Tier;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

/**
 * Le seul outil qui rend du code. Pour le palier Pro, l'abonnement est
 * revérifié ici à chaque appel — pas seulement à la connexion — et chaque
 * source servie est journalisée comme pour la CLI.
 */
#[Name('get-source')]
#[Description('The full source files of a catalog item, with the path each file should be written to. Prefer running the install command from get-item in the user\'s project: flexi:add also installs dependencies. Use this tool when you cannot run commands, or to read the code before adapting it. Pro items require an active Flexiwind Pro subscription.')]
#[IsReadOnly]
#[IsIdempotent]
class GetSourceTool extends Tool
{
    use ValidatesCatalogReference;

    public function __construct(
        private readonly Catalog $catalog,
        private readonly ProRegistry $pro,
    ) {}

    public function handle(Request $request): Response|ResponseFactory
    {
        [$name, $tier] = $this->validatedReference($request);
        $user = $request->user();

        // Le contrôle d'accès passe avant la recherche : sans abonnement, un
        // nom Pro existant et un nom inventé reçoivent la même réponse.
        if ($tier === Tier::Pro && ! $user?->hasProAccess()) {
            return Response::error(
                'This item is part of Flexiwind Pro and no active subscription covers this account. '
                .'Plans: '.route('pricing').'. Free alternatives: call search-catalog with tier "free".'
            );
        }

        $payload = $this->catalog->source($name, $tier);

        if ($payload === null) {
            return Response::error("No {$tier->value} item named \"{$name}\". Use search-catalog to find the exact name.");
        }

        if ($tier === Tier::Pro) {
            $token = request()->attributes->get('api_token');

            $this->pro->recordDownload(
                $user,
                $token instanceof ApiToken ? $token : null,
                $name,
                request()->ip(),
                RegistryDownload::CHANNEL_MCP,
            );
        }

        return Response::structured([
            'name' => $name,
            'tier' => $tier->value,
            'install' => Catalog::installCommand($name, $tier),
            'registryDependencies' => array_values((array) ($payload['registryDependencies'] ?? [])),
            'dependencies' => (array) ($payload['dependencies'] ?? []),
            'files' => array_values(array_map(fn (array $file): array => [
                'target' => (string) ($file['target'] ?? ''),
                'type' => (string) ($file['type'] ?? ''),
                'content' => (string) ($file['content'] ?? ''),
            ], array_filter((array) ($payload['files'] ?? []), 'is_array'))),
            'cssVars' => $payload['cssVars'] ?? null,
            'notes' => $payload['message'] ?? null,
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return $this->referenceSchema($schema);
    }
}
