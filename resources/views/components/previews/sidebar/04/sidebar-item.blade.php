@props(['href' => '#', 'icon' => 'home', 'text' => 'Home', 'isActive' => null])

<li class="flex w-full">
    <a href="{{ $href }}" aria-label="Link to {{ $text }}" data-state="{{ $isActive ? 'active' : 'inactive' }}"
        class="w-full flex items-center gap-x-2.5 px-3 h-9 rounded-ui fx-current:text-white fx-active:text-white
        relative hover:before:bg-bg-muted/60 before:absolute before:rounded-ui before:inset-0 active:before:scale-y-[.95] active:before:scale-x-[.98] before:transition-transform before:transform before:ease-linear fx-active:before:bg-primary fx-current:before:bg-primary
        ">
        <span class="min-w-max inline-flex relative">
            <x-ui.icon name="{{ $icon }}" class="opacity-80"/>
        </span>
        <span class="line-clamp-1 flex-1 relative">
            {{ $text }}
        </span>
    </a>
</li>
