<?php

namespace App\Support;

class SidebarPaginator
{
    /**
     * @var array<int, array<string, mixed>>|null
     */
    private static ?array $flattened = null;

    /**
     * @var array<string, int>|null
     */
    private static ?array $indexesBySlug = null;

    public static function getFlattened(): array
    {
        if (self::$flattened !== null) {
            return self::$flattened;
        }

        self::$flattened = collect(config('sidebar'))
            ->flatMap(function ($group) {
                return collect($group['items'])
                    ->map(fn ($item) => [
                        'title' => $item['title'],
                        'slug' => $item['path'],
                        'description' => $item['description'],
                        'keywords' => $item['keywords'],
                        'seoDescription' => $item['seoDescription'],
                        'ogImage' => [
                            'src' => null,
                            'alt' => null,
                        ],
                    ]);
            })
            ->values()
            ->all();

        self::$indexesBySlug = collect(self::$flattened)
            ->pluck('slug')
            ->flip()
            ->map(static fn (mixed $index): int => (int) $index)
            ->all();

        return self::$flattened;
    }

    public static function getCurrent(string $slug): ?array
    {
        $items = self::getFlattened();
        $index = self::getIndex($slug);

        return $index !== false ? $items[$index] : null;
    }

    public static function getPagger(string $slug): array
    {
        $items = self::getFlattened();
        $index = self::getIndex($slug);

        if ($index === false) {
            return [
                'prev' => null,
                'next' => null,
                'current' => null,
            ];
        }

        return [
            'prev' => $index > 0 ? $items[$index - 1] : null,
            'current' => $items[$index],
            'next' => $index < count($items) - 1 ? $items[$index + 1] : null,
        ];
    }

    private static function getIndex(string $slug): int|false
    {
        self::getFlattened();

        return self::$indexesBySlug[$slug] ?? false;
    }
}
