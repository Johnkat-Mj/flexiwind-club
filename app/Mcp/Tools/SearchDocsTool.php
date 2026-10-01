<?php

namespace App\Mcp\Tools;

use Flexiwind\Docs\DocPage;
use Flexiwind\Docs\DocsIndex;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('search-docs')]
#[Description('Find Flexiwind documentation pages: installation, theming, the CLI, and one page per component with its props and examples. Returns page paths to pass to read-docs.')]
#[IsReadOnly]
#[IsIdempotent]
class SearchDocsTool extends Tool
{
    public function __construct(private readonly DocsIndex $docs) {}

    public function handle(Request $request): ResponseFactory
    {
        $data = $request->validate([
            'query' => ['nullable', 'string', 'max:100'],
            'section' => ['nullable', 'string', 'in:any,docs,components'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:30'],
        ]);

        $terms = array_values(array_filter(preg_split('/\s+/', Str::lower(trim((string) ($data['query'] ?? '')))) ?: []));
        $section = ($data['section'] ?? 'any') === 'any' ? null : $data['section'];
        $results = [];

        foreach ($this->docs->pages() as $page) {
            if ($page->hiddenInSidebar() || ($section !== null && $page->section() !== $section)) {
                continue;
            }

            $score = $this->score($page, $terms);

            if ($terms === [] || $score > 0) {
                $results[] = [$score, $page];
            }
        }

        usort($results, fn (array $a, array $b): int => [$b[0], $a[1]->slug] <=> [$a[0], $b[1]->slug]);

        $pages = array_map(fn (array $result): array => [
            'path' => $result[1]->slug,
            'title' => $result[1]->title(),
            'description' => (string) ($result[1]->meta['description'] ?? ''),
            'url' => url($result[1]->url()),
        ], array_slice($results, 0, (int) ($data['limit'] ?? 10)));

        return Response::structured(['count' => count($pages), 'pages' => $pages]);
    }

    /** @param  list<string>  $terms */
    private function score(DocPage $page, array $terms): int
    {
        $haystacks = [
            50 => Str::lower($page->slug),
            30 => Str::lower($page->title()),
            10 => Str::lower((string) ($page->meta['description'] ?? '').' '.($page->meta['keywords'] ?? '')),
        ];

        $score = 0;

        foreach ($terms as $term) {
            foreach ($haystacks as $weight => $haystack) {
                if (str_contains($haystack, $term)) {
                    $score += $weight;

                    break;
                }
            }
        }

        return $score;
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->description('Words to look for, e.g. "dark mode", "select", "installation".')->max(100),
            'section' => $schema->string()->enum(['any', 'docs', 'components'])
                ->description('docs = guides (installation, theming, CLI); components = one page per component.')
                ->default('any'),
            'limit' => $schema->integer()->min(1)->max(30)->default(10),
        ];
    }
}
