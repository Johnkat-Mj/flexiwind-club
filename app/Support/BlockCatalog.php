<?php

namespace App\Support;

/**
 * Lecture de config/blocks.php, mise à plat pour les pages du site.
 *
 * Le fichier de config range les groupes par catégorie (application,
 * marketing) ; les pages ont surtout besoin de compter et de lister.
 */
final class BlockCatalog
{
    /**
     * @return list<array{key: string, category: string, title: string, description: string, illustrations: array{light?: string, dark?: string}, blocks: array<string, array<string, mixed>>, total: int, free: int, pro: int}>
     */
    public static function groups(): array
    {
        $groups = [];

        foreach ((array) config('blocks', []) as $category => $items) {
            foreach ((array) $items as $key => $group) {
                $blocks = (array) ($group['blocks'] ?? []);
                $pro = count(array_filter($blocks, fn (array $block): bool => ($block['tier'] ?? 'free') === 'pro'));

                $groups[] = [
                    'key' => (string) $key,
                    'category' => (string) $category,
                    'title' => (string) ($group['title'] ?? ucfirst((string) $key)),
                    'description' => (string) ($group['description'] ?? ''),
                    'illustrations' => (array) ($group['illustrations'] ?? []),
                    'blocks' => $blocks,
                    'total' => count($blocks),
                    'free' => count($blocks) - $pro,
                    'pro' => $pro,
                ];
            }
        }

        return $groups;
    }

    /**
     * @return array{total: int, free: int, pro: int}
     */
    public static function totals(): array
    {
        $groups = self::groups();

        return [
            'total' => array_sum(array_column($groups, 'total')),
            'free' => array_sum(array_column($groups, 'free')),
            'pro' => array_sum(array_column($groups, 'pro')),
        ];
    }

    /**
     * Les groupes qui ont une illustration, pour les vitrines visuelles.
     *
     * @return list<array<string, mixed>>
     */
    public static function illustrated(): array
    {
        return array_values(array_filter(self::groups(), fn (array $group): bool => ! empty($group['illustrations']['light'])));
    }
}
