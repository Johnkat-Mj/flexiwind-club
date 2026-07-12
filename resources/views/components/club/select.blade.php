@props(['id', 'multiple' => false, 'defaultValue' => null])

<x-club.select-ui-base x-data x-f-select wire:ignore.self data-select-id="{{ $id }}" :data-default-value="$defaultValue"
    :multiple="$multiple" data-placement="bottom-start">
    {{ $slot }}
</x-club.select-ui-base>
