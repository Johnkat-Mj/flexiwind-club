@props(['selectId' => null, 'placeholder' => null])


<span data-slot="select-value" data-selected-value
    @if ($selectId) data-select-id="{{ $selectId }}" @endif
    {{ $attributes->class(['flex-1 text-start sm:text-sm/6']) }}>
    {{ $slot }}
    @if ($placeholder)
        <span data-placeholder class="text-fg-muted">
            {{ $placeholder }}
        </span>
    @endif
</span>
