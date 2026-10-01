<?php

namespace App\Registry;

use Flexiwind\Docs\BlockRegistry;
use Flexiwind\Docs\DocsIndex;
use Flexiwind\Docs\Tier;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Le catalogue complet, free et Pro, tel que le serveur MCP le présente.
 *
 * Un même nom peut exister dans les deux paliers (`login01` free et
 * `login01` Pro sont deux blocks différents) : un item s'identifie
 * toujours par le couple nom + palier.
 *
 * Les métadonnées (titre, fichiers cibles, dépendances) sont publiques,
 * comme sur le site. Seul source() rend du code, et le contrôle d'accès au
 * code Pro reste à la charge de l'appelant.
 */
final class Catalog
{
    public function __construct(
        private readonly BlockRegistry $blocks,
        private readonly ProRegistry $pro,
        private readonly DocsIndex $docs,
    ) {}

    public function has(string $name, Tier $tier): bool
    {
        if (preg_match('/^'.ProRegistry::NAME_PATTERN.'$/', $name) !== 1) {
            return false;
        }

        return $tier === Tier::Pro
            ? $this->pro->has($name)
            : in_array($name, $this->blocks->names(Tier::Free), true);
    }

    /**
     * Le payload complet, fichiers compris.
     *
     * @return array<string, mixed>|null
     */
    public function source(string $name, Tier $tier): ?array
    {
        if (! $this->has($name, $tier)) {
            return null;
        }

        return $tier === Tier::Pro ? $this->pro->find($name) : $this->blocks->find($name, Tier::Free);
    }

    /**
     * @return array{name: string, tier: string, kind: string, type: string, title: string, description: string, version: string|null, install: string, registryDependencies: list<string>, dependencies: array<string, mixed>, files: list<array{target: string, type: string}>, docs: string|null}|null
     */
    public function item(string $name, Tier $tier): ?array
    {
        return $this->has($name, $tier) ? ($this->items()[$tier->value.':'.$name] ?? null) : null;
    }

    /**
     * Recherche par pertinence : nom exact, puis nom, titre, description.
     *
     * @return list<array<string, mixed>>
     */
    public function search(string $query = '', ?Tier $tier = null, ?string $kind = null, int $limit = 10): array
    {
        $terms = array_values(array_filter(preg_split('/\s+/', Str::lower(trim($query))) ?: []));
        $results = [];

        foreach ($this->items() as $item) {
            if (($tier !== null && $item['tier'] !== $tier->value) || ($kind !== null && $item['kind'] !== $kind)) {
                continue;
            }

            $score = $this->score($item, $terms);

            if ($terms === [] || $score > 0) {
                $results[] = ['score' => $score] + $item;
            }
        }

        usort($results, fn (array $a, array $b): int => [$b['score'], $a['name'], $a['tier']] <=> [$a['score'], $b['name'], $b['tier']]);

        return array_map(
            fn (array $item): array => array_diff_key($item, array_flip(['score', 'files', 'dependencies', 'registryDependencies'])),
            array_slice($results, 0, $limit),
        );
    }

    public static function installCommand(string $name, Tier $tier): string
    {
        return 'php artisan flexi:add '.($tier === Tier::Pro ? '@fx/' : '').$name;
    }

    /**
     * Métadonnées de tout le catalogue, sans le code, indexées par
     * « palier:nom ». Mises en cache : 137 fichiers JSON à relire à chaque
     * recherche, ce serait du disque pour rien.
     *
     * @return array<string, array<string, mixed>>
     */
    private function items(): array
    {
        $free = $this->blocks->names(Tier::Free);
        $pro = array_values(array_filter(array_keys((array) config('registry', [])), $this->pro->has(...)));

        return Cache::remember('catalog:items:'.md5(implode(',', $free).'|'.implode(',', $pro)), now()->addHour(), function () use ($free, $pro): array {
            $items = [];

            foreach ([Tier::Free->value => $free, Tier::Pro->value => $pro] as $tierValue => $names) {
                $tier = Tier::from($tierValue);

                foreach ($names as $name) {
                    $payload = $tier === Tier::Pro ? $this->pro->find($name) : $this->blocks->find($name, Tier::Free);

                    if ($payload !== null) {
                        $items[$tierValue.':'.$name] = $this->describe($name, $tier, $payload);
                    }
                }
            }

            return $items;
        });
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function describe(string $name, Tier $tier, array $payload): array
    {
        $docs = $this->docs->find('components/'.$name);

        return [
            'name' => $name,
            'tier' => $tier->value,
            'kind' => $this->kind($name, $payload),
            'type' => (string) ($payload['type'] ?? 'registry:component'),
            'title' => (string) ($payload['title'] ?? $name),
            'description' => (string) ($payload['description'] ?? ''),
            'version' => isset($payload['version']) ? (string) $payload['version'] : null,
            'install' => self::installCommand($name, $tier),
            'registryDependencies' => array_values(array_map('strval', (array) ($payload['registryDependencies'] ?? []))),
            'dependencies' => (array) ($payload['dependencies'] ?? []),
            'files' => array_values(array_map(fn (array $file): array => [
                'target' => (string) ($file['target'] ?? ''),
                'type' => (string) ($file['type'] ?? ''),
            ], array_filter((array) ($payload['files'] ?? []), 'is_array'))),
            'docs' => $docs ? url($docs->url()) : null,
        ];
    }

    /**
     * Thème, block ou composant. Les payloads ne portent pas l'info : un
     * block se reconnaît à son numéro de variante (login01, kpi-02).
     *
     * @param  array<string, mixed>  $payload
     */
    private function kind(string $name, array $payload): string
    {
        return match (true) {
            ($payload['type'] ?? null) === 'registry:style' => 'theme',
            preg_match('/-?\d+$/', $name) === 1 => 'block',
            default => 'component',
        };
    }

    /**
     * @param  array<string, mixed>  $item
     * @param  list<string>  $terms
     */
    private function score(array $item, array $terms): int
    {
        $score = 0;

        foreach ($terms as $term) {
            $score += match (true) {
                $item['name'] === $term => 100,
                str_contains($item['name'], $term) => 50,
                str_contains(Str::lower($item['title']), $term) => 30,
                str_contains(Str::lower($item['description']), $term) => 10,
                default => 0,
            };
        }

        return $score;
    }
}
