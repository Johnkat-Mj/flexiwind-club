@props(['tone' => 'gray', 'icon' => null])

<span {{ $attributes->class([
    'inline-flex h-5.5 items-center gap-1.25 rounded-full px-2 text-xs font-medium whitespace-nowrap',
    match ($tone) {
        'primary' => 'bg-primary/12 text-primary dark:text-[color-mix(in_oklab,var(--primary)_45%,white)]',
        'success' => 'bg-emerald-600/13 text-emerald-700 dark:text-emerald-400',
        'danger' => 'bg-red-600/12 text-red-600 dark:text-red-400',
        'warning' => 'bg-amber-600/14 text-amber-700 dark:text-amber-400',
        'dark' => 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-900',
        default => 'bg-subtle text-foreground',
    },
]) }}>
    @if ($icon)
        <span aria-hidden="true" class="iconify {{ $icon }} text-[11px]"></span>
    @endif
    {{ $slot }}
</span>
