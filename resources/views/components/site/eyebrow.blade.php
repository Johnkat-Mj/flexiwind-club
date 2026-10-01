@props(['icon' => null])

<span {{ $attributes->class('inline-flex h-7 items-center gap-1.5 rounded-ui border border-input bg-background px-2.5 text-[13px] font-medium text-muted-foreground shadow-xs') }}>
    @if ($icon)
        <span aria-hidden="true" class="iconify {{ $icon }} text-sm text-title-foreground"></span>
    @endif
    {{ $slot }}
</span>
