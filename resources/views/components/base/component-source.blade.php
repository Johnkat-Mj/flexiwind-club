@props([
    'data',
])

@php
    $files = is_array($data) ? $data : [$data];
    $langCache = [];

    $determineLang = static function (string $path) use (&$langCache): string {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (isset($langCache[$extension])) {
            return $langCache[$extension];
        }

        $langCache[$extension] = match ($extension) {
            'php' => 'blade',
            'js' => 'js',
            'ts' => 'ts',
            'css' => 'css',
            'html' => 'html',
            'blade' => 'blade',
            'json' => 'json',
            'md' => 'markdown',
            default => 'text',
        };

        return $langCache[$extension];
    };

    $resolvedData = collect($files)
        ->map(function (string $filePath) use ($determineLang): array {
            $fullPath = base_path($filePath);
            $lang = str_contains($filePath, '.blade') ? 'blade' : $determineLang($filePath);

            if (! file_exists($fullPath)) {
                return [
                    'lang' => $lang,
                    'code' => '',
                    'name' => basename($filePath),
                ];
            }

            $lastModified = filemtime($fullPath);
            $cacheKey = 'file_content_' . md5($filePath . '_' . $lastModified);

            $code = \Illuminate\Support\Facades\Cache::rememberForever($cacheKey, static function () use ($fullPath): string {
                return file_get_contents($fullPath) ?: '';
            });

            return [
                'lang' => $lang,
                'code' => $code,
                'name' => basename($filePath),
            ];
        })
        ->toArray();
@endphp

<x-base.load-code-in-tab :data="$resolvedData" />
