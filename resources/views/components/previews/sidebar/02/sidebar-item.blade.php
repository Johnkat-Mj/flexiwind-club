@props(['isActive'=>false, 'icon','text','href'])
<li>
    <a href="{{ $href }}" data-state="{{ $isActive ? 'active' : 'inactive' }}"
        class="flex items-center gap-3 px-3 py-2 hover:bg-bg-surface fx-active:bg-bg fx-current:bg-bg border border-transparent fx-active:border-border-input fx-current:border-border-input fx-active:shadow-sm fx-active:shadow-bg-muted/50 fx-current:shadow-bg-muted/50 fx-current:shadow-sm fx-active:text-primary group rounded-ui">
        <x-ui.icon size="md" name="{{ $icon }}" />
        <span class="font-medium text-sm group-fx-current:text-fg-title group-fx-active:text-fg-title">
            {{ $text }}
        </span>
    </a>
</li>
