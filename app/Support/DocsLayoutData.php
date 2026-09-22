<?php

namespace App\Support;

class DocsLayoutData
{
    /**
     * @param  array<string, mixed>|null  $current
     * @return array<string, mixed>
     */
    public static function build(?array $current): array
    {
        return [
            'ogImage' => [
                'src' => $current['ogImage']['src'] ?? config('base.default_og_image'),
                'alt' => $current['ogImage']['alt'] ?? config('base.default_og_alt'),
            ],
            'keywords' => trim(config('base.keywords_def').(! empty($current['keywords']) ? ', '.$current['keywords'] : '')),
            'title' => 'Flexiwind | '.($current['title'] ?? ''),
            'description' => $current['seoDescription'] ?? 'Easily add interactive Components to your App.',
        ];
    }
}
