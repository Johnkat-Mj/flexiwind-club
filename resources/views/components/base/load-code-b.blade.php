@props([
    'name',
    'tier' => 'free',
])

@php
    use Flexiwind\Docs\BlockRegistry;
    use Flexiwind\Docs\Tier;

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
            if (str_ends_with($path, '.'.$extension)) {
                return $language;
            }
        }

        return 'plaintext';
    };

    // Le palier passe devant : login01 free et login01 pro sont deux blocks
    // différents qui portent le même nom de payload.
    $payload = app(BlockRegistry::class)->find($name, Tier::tryFrom($tier) ?? Tier::Free);

    $files = $payload['files'] ?? [];
    $isSingle = count($files) <= 1;
    $data = ['name' => '', 'code' => '', 'lang' => 'text', 'lines' => []];

    $toBlock = static fn (array $file): array => [
        'name' => basename($file['target'] ?? $file['path'] ?? ''),
        'code' => $file['content'] ?? '',
        'lang' => $resolveLang($file['target'] ?? $file['path'] ?? ''),
        'lines' => [],
    ];

    if ($files !== []) {
        $data = $isSingle ? $toBlock($files[0]) : array_map($toBlock, $files);
    }
@endphp

@if ($files === [])
    <div class="flex items-center justify-center p-10 text-sm text-muted-foreground">
        Source not published yet for <code class="inline-code inline ml-1">{{ $name }}</code>.
    </div>
@elseif (! $isSingle)
    <x-base.load-code-in-tab :data="$data" />
@else
    <x-base.single-code-block no-title :data="$data" />
@endif
