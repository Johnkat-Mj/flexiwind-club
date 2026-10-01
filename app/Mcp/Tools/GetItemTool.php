<?php

namespace App\Mcp\Tools;

use App\Mcp\Concerns\ValidatesCatalogReference;
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

#[Name('get-item')]
#[Description('Details of one catalog item without its code: what it is, the files flexi:add will create, the other registry items and packages it depends on, its documentation page and the exact install command. Use it to plan an integration before installing.')]
#[IsReadOnly]
#[IsIdempotent]
class GetItemTool extends Tool
{
    use ValidatesCatalogReference;

    public function __construct(private readonly Catalog $catalog) {}

    public function handle(Request $request): Response|ResponseFactory
    {
        [$name, $tier] = $this->validatedReference($request);

        $item = $this->catalog->item($name, $tier);

        if ($item === null) {
            return Response::error("No {$tier->value} item named \"{$name}\". Use search-catalog to find the exact name.");
        }

        return Response::structured($item + [
            'accessible' => $tier === Tier::Free || (bool) $request->user()?->hasProAccess(),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return $this->referenceSchema($schema);
    }
}
