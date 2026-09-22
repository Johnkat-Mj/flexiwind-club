@props(['autoCompleteId', 'placeholder' => 'Type to filter', 'variant' => 'default', 'size' => 'md'])

<x-ui.input data-fx-autocomplete data-select-input data-autocomplete-id="{{ $autoCompleteId }}" type="text"
    placeholder="{{ $placeholder }}" :size="$size" :variant="$variant" {{ $attributes }}/>