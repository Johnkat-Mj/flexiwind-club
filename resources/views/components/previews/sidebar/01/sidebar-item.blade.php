<li>
    <a href="{{ $href }}" data-state="{{ $isActive ? 'active' : 'inactive' }}"
        class="group flex items-center rounded-ui hover:brightness-[0.98] active:brightness-100 text-muted-foreground fx-active:text-title-foreground  fx-current:text-title-foreground  fx-active:bg-white dark:fx-active:bg-gray-800/40 ring ring-transparent fx-active:ring-border-input/50 hover:bg-surface h-9 gap-3.5 pl-3 pr-4">
        <x-ui.icon name="{{ $icon }}" />
        <span class="text-sm">
            {{ $text }}
        </span>
    </a>
</li>
