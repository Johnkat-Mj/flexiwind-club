<?php

namespace App\Mcp\Concerns;

use App\Registry\ProRegistry;
use Flexiwind\Docs\Tier;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;

/**
 * Le couple nom + palier qui désigne un item du catalogue, validé de la
 * même façon par tous les outils.
 */
trait ValidatesCatalogReference
{
    /** @return array<string, Type> */
    protected function referenceSchema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('Registry name of the item, as returned by search-catalog. Lowercase, no "@fx/" prefix. Example: "login01".')
                ->pattern('^'.ProRegistry::NAME_PATTERN.'$')
                ->max(60)
                ->required(),
            'tier' => $schema->string()
                ->enum(['free', 'pro'])
                ->description('"free" for the open-source catalog, "pro" for Flexiwind Pro (the "@fx/" registry). The same name can exist in both.')
                ->default('free'),
        ];
    }

    /** @return array{0: string, 1: Tier} */
    protected function validatedReference(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60', 'regex:/^'.ProRegistry::NAME_PATTERN.'$/'],
            'tier' => ['sometimes', 'string', 'in:free,pro'],
        ], [
            'name.regex' => 'Use the registry name as returned by search-catalog: lowercase letters, digits and dashes, without the "@fx/" prefix.',
            'tier.in' => 'Tier must be "free" or "pro".',
        ]);

        return [$data['name'], Tier::from($data['tier'] ?? 'free')];
    }
}
