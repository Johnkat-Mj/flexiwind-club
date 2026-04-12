@props(['href','icon','text','isActive'=>null])

<li>
    <a href="{{ $href }}" data-state="{{ $isActive ? 'active':'inactive' }}"
        class="flex items-center gap-3 px-3 py-2 
        fx-current:bg-white dark:fx-current:bg-bg-surface fx-current:text-primary fx-current:ring-border-input
        fx-active:bg-white dark:fx-active:bg-bg-surface fx-active:text-primary fx-active:ring-border-input
        text-fg-muted hover:bg-bg-muted/50 ring ring-transparent rounded-ui">
        <span aria-hidden="true" class="iconify opacity-80 {{ $icon }} size-4"></span>
        <span class="font-medium text-sm">
            {{ $text }}
        </span>
    </a>
</li>