@props(['multiple' => false])
<div @if ($multiple) data-multiple @endif
    {{ $attributes->class([
        'ui-popper  group/popover ',
        '[--dropdown-padding:--spacing(1)] [--dropdown-radius:var(--radius-ui)]',
        'p-(--dropdown-padding) rounded-(--dropdown-radius)',
        'border border-foreground/10 bg-background text-muted-foreground shadow-xs',
        'outline-hidden transition-all transform ',
        'sm:text-sm',
        'z-70',
        'min-w-(--select-min-width,var(--trigger-width))',
        'forced-colors:bg-[Canvas]',
        'ui-popper',
        'scroll-py-1 overflow-y-auto overscroll-contain',
        'opacity-0 invisible fx-open:opacity-100 fx-open:visible',
        'ease-linear transition-transform translate-y-1.5 scale-99 fx-open:scale-100 fx-open:translate-y-0',
    ]) }}>
    {{ $slot }}
</div>
