@php
    $sidebarItems = [
        [
            'isActive' => true,
            'text' => "Dashboard",
            'href' => '#',
            'icon' => 'ph--stack'
        ],
        [
            'text' => "Inbox",
            'href' => '#',
            'icon' => 'ph--tray'
        ],
        [
            'text' => "Projects",
            'href' => '#',
            'icon' => 'ph--briefcase'
        ],
        [
            'text' => "Tasks",
            'href' => '#',
            'icon' => 'ph--list-checks'
        ]
    ];
@endphp

<x-ui.sidebar-wrapper
    class="fixed inset-y-0 left-0 
    -translate-x-full fx-open:translate-x-0 fx-open:opacity-100
    md:translate-x-0 md:opacity-100
    z-50 w-70 bg-white/80 dark:bg-bg backdrop-blur-xl border-r border-border-input flex flex-col h-full transform md:static shrink-0">
    <div class="h-16 flex items-center px-4 border-b border-transparent shrink-0">
        <div class="flex items-center justify-between gap-3 w-full">
            <div class="text-fg-title">
                <svg aria-hidden="true" width="488" height="488" class="size-7" viewBox="0 0 488 488" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_13_164)">
                        <path
                            d="M71.5342 71L416.602 416.068V416.068C321.314 511.356 166.822 511.356 71.5342 416.068V416.068C-23.7537 320.78 -23.7537 166.288 71.5342 71V71Z"
                            fill="currentColor" class="text-fg-title"></path>
                        <path
                            d="M483.659 249.5C483.659 274.629 436.788 344.5 411.659 344.5C386.53 344.5 392.659 274.629 392.659 249.5C392.659 224.371 413.03 204 438.159 204C463.288 204 483.659 224.371 483.659 249.5Z"
                            fill="currentColor" class="text-fg-title"></path>
                        <circle cx="243.429" cy="243.759" r="110" transform="rotate(48.3973 243.429 243.759)"
                            fill="black" stroke="white" stroke-width="80" class="fill-fg-title stroke-bg"></circle>
                        <path
                            d="M309 71C309 96.129 212.629 101 187.5 101C162.371 101 142 80.629 142 55.5C142 30.371 162.371 10 187.5 10C212.629 10 309 45.871 309 71Z"
                            fill="currentColor" class="text-fg-title"></path>
                        <path
                            d="M417 101.5C417 126.629 415.129 215.5 390 215.5C364.871 215.5 326 126.629 326 101.5C326 76.371 346.371 56 371.5 56C396.629 56 417 76.371 417 101.5Z"
                            fill="currentColor" class="text-fg-title"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_13_164">
                            <rect width="488" height="488" fill="currentColor" class="text-bg"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div>
                <x-ui.avatar src="https://avatars.githubusercontent.com/u/59884686?v=4" size="sm" radius="ui"
                    width="640" height="427" alt="avatar sm" />
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6">
        <ul class="space-y-0.5">
            @foreach ($sidebarItems as $item)
                <x-previews.sidebar.01.sidebar-item :href="$item['href']" :is-active="$item['isActive']??false"
                    :icon="$item['icon']" :text="$item['text']" />
            @endforeach
        </ul>

        <div class="space-y-0.5">
            <div class="px-3 mb-2 flex items-center justify-between text-fg-muted">
                <span class="text-xs font-medium uppercase tracking-wider">
                    Projects
                </span>
                <span class="cursor-pointer text-fg-muted"></span>
            </div>
            <ul>
                <li>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 
                            fx-current:bg-white dark:fx-current:bg-bg-surface fx-current:text-primary fx-current:ring-border-input
                            fx-active:bg-white dark:fx-active:bg-bg-surface fx-active:text-primary fx-active:ring-border-input
                            text-fg-muted hover:bg-bg-muted/50 ring ring-transparent rounded-ui">
                        <div class="size-5 text-xs rounded d-flex-place-center bg-primary text-white">
                            #
                        </div>
                        <span class="font-medium text-sm">
                            Flexiwind For React
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="space-y-0.5">
            <div class="px-3 mb-2 flex items-center justify-between text-fg-muted">
                <span class="text-xs font-medium uppercase tracking-wider">
                    Teams
                </span>
                <span class="cursor-pointer text-fg-muted"></span>
            </div>
            <ul>
                <li>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 
                        fx-current:bg-white dark:fx-current:bg-bg-surface fx-current:text-primary fx-current:ring-border-input
                        fx-active:bg-white dark:fx-active:bg-bg-surface fx-active:text-primary fx-active:ring-border-input
                        text-fg-muted hover:bg-bg-muted/50 ring ring-transparent rounded-ui">
                        <span class="iconify ph--users size-4 opacity-90"></span>
                        <span class="font-medium text-sm">My workspace</span>
                        <span class="iconify ph--arrow-right size-3.5 ml-auto opacity-60"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="p-3">
        <div class="p-4 rounded-ui bg-bg border border-border-strong/40 ">
            <div class="p-2 mb-2">
                <h2 class="font-medium text-fg-muted text-sm">
                    Upgrade to Pro to get better experience
                </h2>
            </div>
            <x-ui.button size="sm" href="#" class="w-full justify-center">
                Go to pro
            </x-ui.button>
        </div>
    </div>
</x-ui.sidebar-wrapper>