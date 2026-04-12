@props([
    'name',
])

@php
    $langMap = [
        'blade.php' => 'blade',
        'php' => 'php',
        'js' => 'javascript',
        'ts' => 'typescript',
        'vue' => 'vue',
        'css' => 'css',
        'json' => 'json',
        'html' => 'html',
    ];

    $resolveLang = static function (string $path) use ($langMap): string {
        foreach ($langMap as $extension => $language) {
            if (str_ends_with($path, '.' . $extension)) {
                return $language;
            }
        }

        return 'plaintext';
    };

    $registry = config('registry');
    $filePath = $registry[$name] ?? null;
    $isSingle = true;
    $data = ['code' => '', 'lang' => 'text', 'name' => 'any-.php'];

    if ($filePath !== null) {
        $blockData = cache()->remember("block-data:{$name}", now()->addHours(72), function () use ($filePath): ?array {
            $path = resource_path("pro-club/{$filePath}");

            if (! file_exists($path)) {
                return null;
            }

            return json_decode(file_get_contents($path), true);
        });

        if ($blockData !== null) {
            $files = $blockData['files'] ?? [];
            $isSingle = count($files) === 1;

            if ($isSingle && isset($files[0])) {
                $file = $files[0];
                $target = $file['target'] ?? $file['path'];

                $data = [
                    'name' => basename($target),
                    'code' => $file['content'],
                    'lang' => $resolveLang($target),
                ];
            } elseif (! $isSingle) {
                $data = array_map(
                    static fn (array $file): array => [
                        'name' => basename($file['target'] ?? $file['path']),
                        'code' => $file['content'],
                        'lang' => $resolveLang($file['target'] ?? $file['path']),
                    ],
                    $files,
                );
            }
        }
    }
@endphp

@if (! $isSingle)
    <x-base.load-code-in-tab :data="$data" />
@else
    <x-base.single-code-block no-title :data="$data" />
@endif
