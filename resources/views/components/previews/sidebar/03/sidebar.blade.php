@php
    $items = [
        [
            'href' => "#",
            'icon' => 'ph--stack',
            'text' => 'Dashboard',
            'isActive'=>true
        ],
        [
            'href' => '#',
            'icon' => 'ph--folder',
            'text' => 'Contacts',
        ],
        [
            'href' => '#',
            'icon' => 'ph--tray',
            'text' => 'Transactions',
        ],
        [
            'href' => '#',
            'icon' => 'ph--chart-bar',
            'text' => 'Analytics',
        ],
        [
            'href' => '#',
            'icon' => 'ph--lifebuoy',
            'text' => 'Support',
        ],
        [
            'href' => '#',
            'icon' => 'ph--gear',
            'text' => 'Settings',
        ],
    ];
@endphp

<x-ui.sidebar-wrapper
    class="fixed h-dvh py-3 z-40 overflow-hidden w-11/12 max-w-64 md:w-64 lg:w-70 lg:max-w-none transition-all -translate-x-full fx-open:translate-x-0 md:translate-x-0 bg-bg shadow-lg shadow-gray-200/40 dark:shadow-gray-800/60 flex flex-col px-4 md:transition-none ease-linear">
    <div class="min-h-max py-4">
        <a href="#" class="flex items-center gap-x-1.5 font-semibold text-fg-subtitle">
            <span class="bg-linear-to-tr from-primary to-primary/60 text-white size-8 d-flex-place-center rounded-ui">
                <span class="iconify ph--briefcase size-5"></span>
            </span>
            Flexify
        </a>
    </div>
    <nav class="flex flex-1 pt-7 pb-3 w-full">
        <ul class="text-fg-muted space-y-2.5 w-full flex flex-col text-sm">
            @foreach ($items as $item)
                <x-previews.sidebar.03.sidebar-item :is-active="$item['isActive']??false" :href="$item['href']" :icon="$item['icon']" :text="$item['text']" />
            @endforeach
        </ul>
    </nav>

    <div class="mt-6 p-2 rounded-ui bg-bg border border-border-strong/40 ">
        <div class="p-2 mb-2">
            <h2 class="font-medium text-fg-muted text-sm">
                Upgrade to Pro to get better experience
            </h2>
        </div>
        <x-ui.button size="sm" href="#" class="w-full justify-center">
            Go to pro
        </x-ui.button>
    </div>
</x-ui.sidebar-wrapper>
