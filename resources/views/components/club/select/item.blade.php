@props(['value'])

@php
    $attributes = $attributes->class([
        'dropdown-item-base',
        'dropdown-item-base-vars',
        'min-w-0 [--mr-icon:--spacing(2.5)] sm:[--mr-icon:--spacing(2)]',
        'not-has-[[slot=description]]:items-center',
        'group relative cursor-default select-none dropdown-item-radius rounded-dropdown-item text-left',
        'text-base/6 sm:text-sm/6 forced-colors:text-[CanvasText]',
        'ease-linear duration-200',
        'dropdown-item-grid',
        'dropdown-item-icon',
        'dropdown-item-keyboard',
        'dropdown-item-description',
        'dropdown-item-has-description',
        'dropdown-item-label',
        'dropdown-item-avatar',
        'dropdown-item-force-color',
        'dropdown-item-hover',
        'dropdown-item-disabled',
        'dropdown-item-selected',
        'dropdown-item-selected-icon',
        'dropdown-item-selected-avatar-icon',
        'dropdown-item-selected-avatar',
        'ease-linear duration-200',
    ]);
@endphp
<li data-select-item="{{ $value }}" {{ $attributes }}>
    <span aria-hidden="true" data-slot="check-indicator"
        class="mr-1.5 -ml-0.5 h-lh shrink-0 iconify ph--check-bold text-xs flex
                not-group-selected:hidden
                group-has-data-[slot=icon]:absolute group-has-data-[slot=icon]:top-1/2 group-has-data-[slot=icon]:right-0.5 group-has-data-[slot=icon]:-translate-y-1/2
                group-has-data-[slot=avatar]:absolute group-has-data-[slot=avatar]:top-1/2 group-has-data-[slot=avatar]:right-0.5 group-has-data-[slot=avatar]:-translate-y-1/2"></span>
    <x-club.select.label>
        {{ $slot }}
    </x-club.select.label>
    {{-- check if slot is string only --}}
    {{-- if string  => render <x-ui.dropdown.label> {{ $slot }}</x-ui.dropdown.label> --}}
    {{-- else render {{ $slot }} --}}
</li>
