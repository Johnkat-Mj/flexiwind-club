@php
    $seo = [
        'ogImage' => [
            'src' => $ogImage['src'] ?? '/cover-flexiwind.png',
            'alt' => $ogImage['alt'] ?? 'Flexiwind — Tailwind CSS Components & Blocks for Laravel',
        ],
        'keywords' => trim('flexiwind, laravel ui, laravel components, laravel blocks, livewire components, tailwind css, tailwind v4, blade components, laravel ui kit, copy paste ui, laravel blade'),
        'title' => 'Flexiwind — Tailwind CSS Components & Blocks for Laravel',
        'description' => $description ?? 'Beautifully designed, copy-paste ready Tailwind CSS v4 components and Livewire blocks for Laravel. Build stunning UIs faster.',
    ];
@endphp

<x-layouts.base
    body-class="bg-background flex flex-col"
    :seo="$seo"
    :script-entries="['resources/js/app.js', 'resources/js/flexilla.js', 'resources/js/block.js']"
>
    <x-site.rails />
    <x-layouts::site-header />
    {{ $slot }}
    <x-layouts::site-footer />
    <x-blocks.modal-search />
</x-layouts.base>
