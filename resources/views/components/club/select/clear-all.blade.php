@props(['selectId'])

<button data-select-clear-all data-select-id="{{ $selectId }}" {{ $attributes }}>{{ $slot }}</button>
