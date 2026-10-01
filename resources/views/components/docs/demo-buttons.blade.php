@props(['variant' => 'solid'])
@php
    // Uniquement les intents définis pour chaque variant dans intents.css.
    $intents = match ($variant) {
        'solid' => ['primary', 'secondary', 'accent', 'neutral', 'destructive', 'success'],
        'soft' => ['primary', 'destructive', 'success', 'gray'],
        'ghost' => ['gray', 'success'],
        'outline' => ['gray'],
        default => ['primary'],
    };
@endphp
<div class="flex flex-wrap items-center gap-2.5 justify-center">
    @foreach ($intents as $intent)
        <x-ui.button :variant="$variant" :intent="$intent">
            {{ ucfirst($intent) }}
        </x-ui.button>
    @endforeach
</div>
