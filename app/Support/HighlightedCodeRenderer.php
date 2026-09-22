<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class HighlightedCodeRenderer
{
    public static function render(string $code, string $lang = 'php', array $lines = []): string
    {
        $cacheKey = 'highlighted_'.md5($code.$lang.serialize($lines));

        return Cache::rememberForever($cacheKey, function () use ($code, $lang, $lines): string {
            try {
                $shiki = ShikiService::getInstance('aurora-x');
                $highlighted = $shiki->highlightCode($code, $lang);

                return self::injectLineClasses($highlighted, $lines);
            } catch (\Throwable $exception) {
                logger()->error('Code highlighting failed', [
                    'lang' => $lang,
                    'error' => $exception->getMessage(),
                ]);

                return '<pre><code>'.e($code).'</code></pre>';
            }
        });
    }

    private static function injectLineClasses(string $html, array $lineClasses): string
    {
        if ($lineClasses === []) {
            return $html;
        }

        $lineIndex = 0;

        return preg_replace_callback(
            '/<span class="line(.*?)">/',
            function (array $matches) use ($lineClasses, &$lineIndex): string {
                $lineIndex++;
                $extraClass = $lineClasses[$lineIndex] ?? null;

                if ($extraClass) {
                    return '<span class="line'.$matches[1].' line--'.$extraClass.'">';
                }

                return $matches[0];
            },
            $html,
        ) ?? $html;
    }
}
