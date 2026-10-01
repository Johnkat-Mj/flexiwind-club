{{--
    Onglet Code d'un block : lit le payload du registre (le même que celui
    qu'installe flexi:add) et choisit la vue fichier unique ou éditeur.
--}}
@props(['name', 'tier' => 'free', 'flush' => false])

@php
    use Flexiwind\Docs\BlockRegistry;
    use Flexiwind\Docs\Tier;

    $payload = app(BlockRegistry::class)->find($name, Tier::tryFrom($tier) ?? Tier::Free);
    $files = array_map(fn (array $file): array => [
        'target' => (string) ($file['target'] ?? $file['path'] ?? $name),
        'code' => (string) ($file['content'] ?? ''),
    ], $payload['files'] ?? []);
    $dependencies = array_values((array) ($payload['registryDependencies'] ?? []));
@endphp

<div {{ $attributes->class(['relative size-full min-h-80 overflow-hidden bg-code', 'rounded-ui' => ! $flush]) }}>
    @if ($files === [])
        <div class="flex h-full items-center justify-center p-10 text-sm text-code-muted">
            Source not published yet for <code class="ml-1 font-mono text-code-foreground">{{ $name }}</code>.
        </div>
    @elseif (count($files) === 1)
        <x-code-panel.single :target="$files[0]['target']" :code="$files[0]['code']" :dependencies="$dependencies" />
    @else
        <x-code-panel.editor :name="$name" :files="$files" :dependencies="$dependencies" />
    @endif
</div>
