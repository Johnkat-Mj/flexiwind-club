@php
    $seo = [
        'ogImage' => [
            'src' => $ogImage['src'] ?? config('app.default_og_image', '/default-og.png'),
            'alt' => $ogImage['alt'] ?? config('app.default_og_alt', 'Default OG Alt'),
        ],
        'keywords' => trim(config('app.keywords_def', 'docs, flexiwind')),
        'title' => 'Flexiwind | Laravel UI',
        'description' => $description ?? 'Easily add interactive Components to your App.',
    ];
@endphp

<x-layouts.base body-class="bg-bg flex flex-col" :seo="$seo">
    <x-organisms.navbar />
    {{ $slot }}
    <x-organisms.footer />
    <x-blocks.modal-search />
    <span class="fixed inset-y-0 left-0 w-2 border-r border-border pointer-events-none"></span>
    <span class="fixed inset-y-0 right-0 w-2 border-l border-border pointer-events-none"></span>
</x-layouts.base>
