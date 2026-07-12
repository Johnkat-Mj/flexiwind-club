@props([
    'selectId',
    'border' => true,
    'size' => 'md',
    'bg' => true,
    'radius' => true,
    'invalid' => false,
])


<button data-fx-select data-select-trigger data-select-id="{{ $selectId }}"
    @if ($invalid) data-invalid @endif
    {{ $attributes->class([
        'relative group flex items-center gap-2',
        'disabled:hover:cursor-not-allowed disabled:opacity-80 ',
        'outline-offset-0 focus:outline-offset-0 focus:border-transparent',
        'outline outline-transparent focus:outline-(--ui-input-focus-outline) ring-transparent',
        'ring-offset-transparent focus:ring-(--focus-ring) ring-3 ring-offset-1 transition-all',
        'ease-linear duration-200 **:line-clamp-1 *:first:flex-1 *:text-start',
        'ui-form-input-sm' => $size === 'sm',
        'ui-form-input-md' => $size === 'md',
        'ui-form-input-lg' => $size === 'lg',
        'rounded-ui' => $radius,
        'border border-border-input hover:border-fg-muted/30' => $border,
    ]) }}>
    {{ $slot }}
    <span data-slot="chevron" class="min-w-4 flex -mr-1 size-4 text-fg-muted  iconify ph--caret-up-down"></span>
</button>
