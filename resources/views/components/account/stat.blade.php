@props(['label', 'icon', 'value', 'hint' => ''])

<div {{ $attributes->class('flex flex-col gap-2.5 rounded-2xl border border-border bg-background px-5 py-4.5 shadow-xs') }}>
    <p class="flex items-center justify-between text-[13.5px] text-muted-foreground">
        {{ $label }}
        <span class="flex size-7.5 items-center justify-center rounded-[9px] bg-primary/10 text-primary">
            <span aria-hidden="true" class="iconify {{ $icon }} text-[15px]"></span>
        </span>
    </p>
    <p class="font-display truncate text-[26px]/7.5 font-semibold tracking-[-0.03em] text-title-foreground">{{ $value }}</p>
    @if ($hint)
        <p class="text-[13px] text-muted-foreground">{{ $hint }}</p>
    @endif
    {{ $slot }}
</div>
