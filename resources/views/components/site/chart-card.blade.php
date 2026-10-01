{{-- Carte de graphique de la page Charts : la valeur et l'écart viennent d'Alpine. --}}
@props(['title', 'value', 'delta'])

<div class="bg-dots flex size-full items-center justify-center bg-surface p-3 sm:p-7">
    <div class="flex size-full max-w-215 flex-col gap-3.5 rounded-[14px] border border-border bg-background px-5 py-5 shadow-[0_14px_32px_-20px_rgba(9,9,11,.25)] sm:px-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <span class="flex flex-col gap-1">
                <span class="text-[13px] text-muted-foreground">{{ $title }}</span>
                <span class="flex items-baseline gap-2.5">
                    <span class="font-display text-3xl font-semibold tracking-[-0.03em] text-title-foreground" x-text="{{ $value }}"></span>
                    <span class="text-[13px] font-medium text-success" x-text="{{ $delta }}"></span>
                </span>
            </span>
            {{ $legend ?? '' }}
        </div>
        {{ $slot }}
    </div>
</div>
