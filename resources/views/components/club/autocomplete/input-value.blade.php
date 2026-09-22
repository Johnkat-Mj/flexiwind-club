@props(['selectId', 'name', 'defaultValue' => null])

<input type="hidden" data-select-value data-select-id="{{ $selectId }}" name="{{ $name }}"
    {{ $attributes }} />
