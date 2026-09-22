@props(['id', 'defaultValue' => null, 'multiple' => false])



<x-club.select-ui-base x-data x-f-auto-complete wire:ignore.self data-select-content
     data-select-id="{{ $id }}" :data-default-value="$defaultValue"
    data-placement="bottom-start" {{ $attributes->class(['']) }} :multiple="$multiple">
    {{ $slot }}
</x-club.select-ui-base>
