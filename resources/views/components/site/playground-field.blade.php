{{-- Un réglage du panneau Customize : libellé, valeur courante (expression Alpine) ou aide. --}}
@props(['label', 'value' => null, 'hint' => null])

<div class="flex flex-col gap-2.25">
    <div class="flex items-center justify-between">
        <span class="text-[12.5px] font-semibold text-title-foreground">{{ $label }}</span>
        @if ($value)
            <span class="text-xs text-muted-foreground" x-text="{{ $value }}"></span>
        @elseif ($hint)
            <span class="text-xs text-muted-foreground">{{ $hint }}</span>
        @endif
    </div>
    {{ $slot }}
</div>
