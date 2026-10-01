{{--
    Carte de l'espace compte. `actions` se place à droite du titre ; sans
    titre, la carte n'a pas d'en-tête.
--}}
@props(['title' => '', 'description' => '', 'padding' => 'p-5 sm:p-6'])

<section {{ $attributes->class(['overflow-hidden rounded-2xl border border-border bg-background shadow-xs']) }}>
    @if ($title)
        <header class="flex items-start justify-between gap-4 border-b border-border px-5 pt-5 pb-4 sm:px-6">
            <div>
                <h2 class="font-display text-[17px] font-semibold tracking-[-0.015em] text-title-foreground">{{ $title }}</h2>
                @if ($description)
                    <p class="mt-0.5 text-[13.5px]/5 text-muted-foreground">{{ $description }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </header>
    @endif
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</section>
