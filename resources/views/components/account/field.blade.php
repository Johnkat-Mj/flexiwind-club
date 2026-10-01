{{--
    Un champ de l'espace compte : libellé, icône en tête, icône de fin
    (un cadenas pour un champ en lecture seule), aide et erreur. Les
    attributs (wire:model, type, placeholder…) vont à l'input.
--}}
@props(['label', 'id', 'icon' => null, 'trailingIcon' => null, 'error' => null, 'hint' => null, 'invalid' => false, 'describedBy' => null])

@php
    $locked = $attributes->has('readonly') || $attributes->has('disabled');
    // `invalid` sans `error` : le message est affiché ailleurs (sous une ligne champ + bouton).
    $invalid = $invalid || $error !== null;
    $describedBy = trim(($hint ? "{$id}-hint " : '').($error !== null ? "{$id}-error " : '').($invalid ? ($describedBy ?? '') : ''));
@endphp

<div class="flex min-w-0 flex-col gap-1.75">
    <label for="{{ $id }}" class="text-[13.5px]/4 font-medium text-title-foreground">{{ $label }}</label>

    <div @class([
        'relative flex h-10 items-center gap-2.25 rounded-[10px] border px-3 transition-[border-color,box-shadow] duration-200',
        'border-border-input bg-background focus-within:border-primary/70 focus-within:ring-3 focus-within:ring-(--focus-ring)' => ! $locked && ! $invalid,
        'border-destructive bg-background ring-3 ring-destructive/15' => $invalid,
        'border-border-input bg-surface' => $locked && ! $invalid,
    ])>
        @if ($icon)
            <span aria-hidden="true" class="iconify {{ $icon }} size-4 shrink-0 text-muted-foreground"></span>
        @endif
        <input id="{{ $id }}"
            @if ($invalid) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['type' => 'text'])->class([
                'h-full min-w-0 flex-1 border-0 bg-transparent p-0 text-sm outline-none placeholder:text-muted-foreground',
                'text-title-foreground' => ! $locked,
                'cursor-default text-muted-foreground' => $locked,
            ]) }}>
        @if ($trailingIcon)
            <span aria-hidden="true" class="iconify {{ $trailingIcon }} size-4 shrink-0 text-muted-foreground"></span>
        @endif
    </div>

    @if ($hint)
        <p id="{{ $id }}-hint" class="text-[12.5px]/4.5 text-muted-foreground">{{ $hint }}</p>
    @endif
    @if ($error !== null)
        <p id="{{ $id }}-error" class="text-xs text-destructive">{{ $error }}</p>
    @endif
</div>
