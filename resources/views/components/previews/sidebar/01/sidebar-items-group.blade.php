@props(['id', 'icon', 'text', 'items' => []])
<div class="flex flex-col w-full">
    <x-ui.collapse.trigger target="sidebar-{{ $id }}" indicator-class="size-3.5"
        class="group flex gap-3.5 items-center rounded-ui
                hover:brightness-[0.98] active:brightness-100
                text-fg-muted fx-active:text-fg-title fx-current:text-fg-title
                fx-active:bg-white dark:fx-active:bg-gray-800/40
                hover:bg-bg-surface h-9 pl-3 pr-3 text-sm">
        <div class="flex items-center gap-3.5 flex-1">
            <span aria-hidden="true" class="iconify {{ $icon }} size-4"></span>
            <span class="truncate">{{ $text }}</span>
        </div>
    </x-ui.collapse.trigger>
    <x-ui.collapse id="sidebar-{{ $id }}" class="pl-5">
        <ul class="border-l border-border-strong/80 pl-1 flex flex-col space-y-1">
            @foreach ($items as $item)
                <li>
                    <a href="{{ $item['href'] }}"
                        class="rounded-ui flex items-center
                hover:brightness-[0.98] active:brightness-100
                text-fg-muted fx-active:text-fg-title fx-current:text-fg-title
                fx-active:bg-white dark:fx-active:bg-gray-800/40
                hover:bg-bg-surface h-9 px-3 text-sm">
                        <span>
                            {{ $item['text'] }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </x-ui.collapse>
</div>
