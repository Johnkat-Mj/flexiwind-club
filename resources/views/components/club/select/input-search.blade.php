@props(['selectId', 'size' => 'md', 'variant' => 'default'])
<x-ui.input data-select-input data-select-id="selectId" type="search" :size="$size" :variant="$variant"
    {{ $attributes }} />
