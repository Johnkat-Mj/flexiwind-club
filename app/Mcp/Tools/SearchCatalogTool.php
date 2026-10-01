<?php

namespace App\Mcp\Tools;

use App\Registry\Catalog;
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

#[Name('search-catalog')]
#[Description('Search the Flexiwind catalog of Blade/Livewire UI components, page blocks and themes, free and Pro. Use it first to find the exact registry name and tier of what you need (for example "login page", "select", "sidebar"). Returns the install command for each match.')]
#[IsReadOnly]
#[IsIdempotent]
class SearchCatalogTool extends Tool
{
    public function __construct(private readonly Catalog $catalog) {}

    public function handle(Request $request): ResponseFactory
    {
        $data = $request->validate([
            'query' => ['nullable', 'string', 'max:100'],
            'tier' => ['nullable', 'string', 'in:any,free,pro'],
            'kind' => ['nullable', 'string', 'in:any,component,block,theme'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:25'],
        ]);

        $tier = ($data['tier'] ?? 'any') === 'any' ? null : Tier::from($data['tier']);
        $kind = ($data['kind'] ?? 'any') === 'any' ? null : $data['kind'];

        $items = $this->catalog->search((string) ($data['query'] ?? ''), $tier, $kind, (int) ($data['limit'] ?? 10));
        $hasPro = (bool) $request->user()?->hasProAccess();

        $items = array_map(fn (array $item): array => $item + [
            'accessible' => $item['tier'] === Tier::Free->value || $hasPro,
        ], $items);

        return Response::structured([
            'count' => count($items),
            'items' => $items,
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->description('Words to look for in names, titles and descriptions. Leave empty to browse.')->max(100),
            'tier' => $schema->string()->enum(['any', 'free', 'pro'])->default('any'),
            'kind' => $schema->string()->enum(['any', 'component', 'block', 'theme'])
                ->description('component = a UI primitive (button, select…), block = a ready-made page section (login01, sidebar02…), theme = a color theme.')
                ->default('any'),
            'limit' => $schema->integer()->min(1)->max(25)->default(10),
        ];
    }
}
