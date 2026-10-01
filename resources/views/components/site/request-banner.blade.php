{{-- Bandeau « il vous manque quelque chose ? » en bas des catalogues. --}}
@props(['title', 'text', 'action', 'href' => 'https://github.com/unoforge/flexiwind/issues/new'])

<div class="flex flex-col gap-6 rounded-[20px] border border-border bg-surface p-6 sm:p-9 md:flex-row md:items-center md:justify-between">
    <div class="flex items-center gap-4.5">
        <span class="flex size-13 shrink-0 items-center justify-center rounded-[14px] bg-primary/10 text-primary">
            <span aria-hidden="true" class="iconify ph--sparkle text-2xl"></span>
        </span>
        <span class="flex flex-col gap-1">
            <span class="font-display text-[22px] font-semibold tracking-[-0.02em] text-title-foreground">{{ $title }}</span>
            <span class="text-[15px] text-muted-foreground">{{ $text }}</span>
        </span>
    </div>
    <div class="flex flex-wrap gap-2.5">
        <x-ui.button :href="$href" variant="outline" intent="gray" class="h-11 rounded-[10px] px-4.5 font-medium text-title-foreground">{{ $action }}</x-ui.button>
        @guest
            <x-ui.button href="{{ route('pricing') }}" wire:navigate class="h-11 gap-2 rounded-[10px] px-4.5 font-medium">
                Get Pro <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
            </x-ui.button>
        @endguest
    </div>
</div>
