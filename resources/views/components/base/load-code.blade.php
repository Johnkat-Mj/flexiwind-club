@props([
    'name',
])

@php
    $isSingle = is_string($name);
    $docs = cache()->remember('docs_code_all_', now()->addHours(24), static fn (): array => \App\Support\DocsCode::all());

    if ($isSingle) {
        $data = $docs[$name] ?? ['code' => '', 'lang' => 'text'];
    } else {
        $data = collect($name)
            ->filter(static fn ($item): bool => isset($docs[$item]))
            ->map(static fn ($item): array => $docs[$item])
            ->values()
            ->toArray();
    }
@endphp

@if (! $isSingle)
    <x-base.load-code-in-tab :data="$data" />
@else
    <x-base.single-code-block :data="$data" />
@endif
