{{-- Carte d'un template : aperçu à gauche, pages et stack à droite. --}}
@props(['template'])

@php
    $isFree = $template['tier'] === 'free';
@endphp

<article {{ $attributes->class('grid overflow-hidden rounded-[22px] border border-border bg-background shadow-xs lg:h-115 lg:grid-cols-[minmax(0,660px)_minmax(0,1fr)]') }}>
    <a href="{{ route('templates.show', $template['key']) }}" wire:navigate
        class="bg-dots group relative block h-64 overflow-hidden border-b border-border bg-surface sm:h-80 lg:h-auto lg:border-r lg:border-b-0">
        <img src="/images/{{ $template['image'] }}.webp" alt="{{ $template['title'] }} preview"
            class="absolute top-6 left-6 aspect-4/3 w-[calc(100%-1rem)] max-w-150 rounded-xl border border-border object-cover object-top shadow-[0_30px_60px_-28px_rgba(9,9,11,.4)] transition-transform duration-300 group-hover:-translate-y-1 sm:top-10 sm:left-10 dark:hidden">
        <img src="/images/{{ $template['image'] }}-dark.webp" alt="{{ $template['title'] }} preview"
            class="absolute top-6 left-6 hidden aspect-4/3 w-[calc(100%-1rem)] max-w-150 rounded-xl border border-border object-cover object-top shadow-[0_30px_60px_-28px_rgba(9,9,11,.4)] transition-transform duration-300 group-hover:-translate-y-1 sm:top-10 sm:left-10 dark:block">
    </a>
    <div class="flex flex-col p-6 sm:p-9">
        <div class="flex items-center gap-2.5">
            <h2 class="font-display text-[28px]/[1.2] font-semibold tracking-[-0.025em] text-title-foreground">{{ $template['title'] }}</h2>
            <x-landing.tier-pill :free="$isFree" />
        </div>
        <p class="mt-2.5 text-[15px]/6 text-muted-foreground">{{ $template['summary'] }}</p>

        <span class="mt-6 text-xs font-semibold tracking-[.06em] text-muted-foreground uppercase">Pages inside</span>
        <div class="mt-2.5 flex flex-wrap gap-2">
            @foreach ($template['pages'] as $page)
                <span class="flex h-7 items-center rounded-lg border border-border px-2.5 text-[13px] text-title-foreground">{{ $page }}</span>
            @endforeach
        </div>

        <span class="mt-5.5 text-xs font-semibold tracking-[.06em] text-muted-foreground uppercase">Built with</span>
        <div class="mt-2.5 flex flex-wrap gap-2">
            @foreach ($template['stack'] as $tool)
                <span @class([
                    'flex h-7 items-center rounded-lg px-2.5 text-[13px]',
                    'bg-primary/10 font-medium text-primary' => $tool === 'Flexiwind',
                    'bg-subtle text-foreground' => $tool !== 'Flexiwind',
                ])>{{ $tool }}</span>
            @endforeach
        </div>

        <div class="mt-8 flex flex-wrap gap-2.5 lg:mt-auto">
            <x-ui.button href="{{ route('templates.show', $template['key']) }}" wire:navigate class="h-11 gap-2 rounded-[10px] px-4.5 font-medium">
                View template <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
            </x-ui.button>
            @if ($template['url'])
                <x-ui.button :href="$template['url']" variant="outline" intent="gray" class="h-11 gap-2 rounded-[10px] px-4.5 font-medium text-title-foreground">
                    <span aria-hidden="true" class="iconify ph--github-logo"></span>View on GitHub
                </x-ui.button>
            @else
                <x-ui.button href="{{ route('templates.show', $template['key']) }}#preview" wire:navigate variant="outline" intent="gray"
                    class="h-11 rounded-[10px] px-4.5 font-medium text-title-foreground">Live preview</x-ui.button>
            @endif
        </div>
    </div>
</article>
