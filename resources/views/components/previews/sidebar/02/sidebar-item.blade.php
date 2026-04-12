<li>
    <a href="{{ $href }}"
    data-state="{{ $isActive ? 'active':'inactive' }}"
        class="group flex items-center rounded-ui
                hover:brightness-[0.98] active:brightness-100
                text-fg-muted fx-active:text-fg-title fx-current:text-fg-title
                fx-active:bg-white dark:fx-active:bg-gray-800/40
                ring ring-transparent fx-active:ring-border-input/50
                hover:bg-bg-surface h-9 gap-3.5 pl-3 pr-4
      ">

        <span aria-hidden="true" class="iconify {{ $icon }} size-4"></span>
        <span class="text-sm">
            {{ $text }}
        </span>
    </a>
</li>
