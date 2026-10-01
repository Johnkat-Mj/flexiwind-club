<?php

namespace App\Mcp\Tools;

use Flexiwind\Docs\DocsIndex;
use Flexiwind\Docs\FrontMatter;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

/**
 * Seules les pages connues de l'index sont lisibles : le chemin reçu n'est
 * jamais concaténé à un répertoire, il sert de clé dans l'index. Une
 * traversée (`../`) ne correspond à aucune clé et ne touche pas le disque.
 */
#[Name('read-docs')]
#[Description('Read one Flexiwind documentation page as Markdown: usage, props, variants and examples of a component, or a guide. Pass a path from search-docs, e.g. "components/button" or "docs/installation".')]
#[IsReadOnly]
#[IsIdempotent]
class ReadDocsTool extends Tool
{
    /** Au-delà, la page est tronquée : une doc n'a pas à remplir le contexte d'un agent. */
    private const MAX_CHARACTERS = 60_000;

    public function __construct(private readonly DocsIndex $docs) {}

    public function handle(Request $request): Response
    {
        $data = $request->validate([
            'path' => ['required', 'string', 'max:120', 'regex:/^[a-z0-9]+(?:[-\/][a-z0-9]+)*$/'],
        ], [
            'path.regex' => 'Use a page path as returned by search-docs, e.g. "components/button".',
        ]);

        $page = $this->docs->find($data['path']);

        if ($page === null || $page->hiddenInSidebar()) {
            return Response::error("No documentation page at \"{$data['path']}\". Use search-docs to find one.");
        }

        [, $body] = FrontMatter::parse((string) file_get_contents($page->file));

        $markdown = '# '.$page->title()."\n\nSource: ".url($page->url())."\n\n".trim($body);

        return Response::text(Str::limit($markdown, self::MAX_CHARACTERS, "\n\n[…truncated — open the page URL for the rest]"));
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'path' => $schema->string()
                ->description('Page path from search-docs, e.g. "components/select".')
                ->pattern('^[a-z0-9]+(?:[-/][a-z0-9]+)*$')
                ->max(120)
                ->required(),
        ];
    }
}
