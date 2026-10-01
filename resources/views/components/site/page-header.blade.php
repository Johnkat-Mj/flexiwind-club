{{--
    En-tête des pages intérieures (Blocks, Templates, Charts…). Le slot
    `actions` se place à droite, sous forme de colonne alignée en bas.
--}}
@props(['icon' => null, 'eyebrow' => null, 'title', 'muted' => null, 'center' => false])

<x-site.section grid class="overflow-hidden">
    <x-site.container {{ $attributes->class([
        'flex flex-col gap-8 pt-12 pb-12 sm:pt-14',
        'items-center text-center' => $center,
        'lg:flex-row lg:items-end lg:justify-between' => ! $center,
    ]) }}>
        <div @class(['flex flex-col', 'items-center' => $center, 'items-start' => ! $center])>
            @if ($eyebrow)
                <x-site.eyebrow :icon="$icon">{{ $eyebrow }}</x-site.eyebrow>
            @endif
            <h1 class="font-display mt-3.5 text-4xl/tight font-semibold tracking-[-0.04em] text-balance text-title-foreground sm:text-5xl/[1.1] lg:text-[3.25rem]/[1.1]">
                {{ $title }}@if ($muted)
                    <span class="text-subtitle">{{ $muted }}</span>
                @endif
            </h1>
            @if ($slot->isNotEmpty())
                <p class="mt-3 max-w-140 text-base/relaxed text-pretty text-muted-foreground">{{ $slot }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="flex flex-col items-start gap-3 lg:items-end">{{ $actions }}</div>
        @endisset
    </x-site.container>
</x-site.section>
