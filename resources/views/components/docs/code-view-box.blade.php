@props([
    'class' => '',
    'defaultSetting' => false,
    'unstilled' => false,
    'noCopyButton' => false,
    'isShell' => false,
    // Rembourrage standard du bloc de code. Symétrique, avec un padding
    // horizontal : l'ancien `pt-3 pb-10` collait le code au bord gauche et
    // laissait un vide en bas. Les blocs qui gèrent leur propre rembourrage
    // (single-code-block, via [&_figure>pre]) passent padding="".
    'padding' => null,
])

@php
    $padding ??= 'px-4 py-3';
@endphp

<div data-code-component data-code-block data-code-box-collapsible
    class="relative group {{ !$unstilled ? 'overflow-hidden max-h-140 xl:max-h-160 w-full grid' : '' }} {{ $defaultSetting ? 'rounded-ui bg-(--astro-code-color-background)' : '' }} {{ $class }}">
    @if (!$noCopyButton)
        <x-atoms.btn-copy-code
            class="absolute top-4 right-4 z-40 invisible flex opacity-0 group-hover:visible group-hover:opacity-100 text-gray-300" />
    @endif
    <div class="w-full flex h-full overflow-auto bg-[#07090F] {{ $padding }}">
        {{ $slot }}
    </div>
</div>
