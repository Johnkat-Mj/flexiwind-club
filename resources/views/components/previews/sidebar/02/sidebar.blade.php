@php
    $sidebarItems = [
        [
            'id' => '01',
            'text' => 'Home',
            'isActive' => true,
            'href' => '#',
            'icon' => 'ph--presentation-chart',
        ],
        [
            'id' => '02',
            'text' => 'My Tasks',
            'href' => '#',
            'icon' => 'ph--users-three',
        ],
        [
            'id' => '03',
            'text' => 'Inbox',
            'href' => '#',
            'icon' => 'ph--tray',
        ],
    ];
@endphp
<x-ui.sidebar-wrapper
    class="fixed lg:static h-dvh overflow-hidden w-11/12 max-w-66 md:w-66 transition-all -translate-x-full fx-open:translate-x-0 lg:translate-x-0 bg-background flex flex-col justify-between lg:transition-none ease-linear z-50 lg:z-auto border-r border-border-input/40">
    <nav class="size-full flex flex-col">
        <div class="pl-5 pr-3 h-16 flex items-center py-2">
            <div class="h-16 w-full py-2 flex items-center border-b border-transparent">
                <div
                    class="flex items-center gap-3 w-full p-1.5 rounded-ui text-foreground hover:bg-surface cursor-pointer transition-colors duration-200">
                    <div
                        class="size-8 bg-primary rounded-ui flex items-center justify-center text-white shadow-sm shadow-primary-200 dark:shadow-primary-900">
                        <svg class="size-5" width="553" height="553" viewBox="0 0 553 553" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M481.749 50.0439C505.676 39.5719 533 57.2231 533 85.3984V138.658C533 159.197 516.518 178.892 492.788 185.605C462.86 194.072 425.008 209.43 397.361 237.488C357.828 277.611 333.78 330.507 309.238 374.237C283.916 419.359 257.031 457.516 211.177 479.877C166.76 501.537 107.535 515.512 61.9404 523.736C40.2339 527.652 20 510.74 20 486.759V449.633C20.0001 428.679 36.1714 411.275 57.0693 409.74L79.0049 408.129C84.3302 407.738 89.5933 406.739 94.6914 405.151L137.944 391.681C143.756 389.871 149.306 387.31 154.455 384.064L159.405 380.943C176.822 369.966 191.117 354.696 200.921 336.605L201.384 335.742L207.755 323.755L208.043 323.212L208.298 322.652L208.301 322.645C208.304 322.637 208.31 322.625 208.317 322.608C208.333 322.574 208.358 322.521 208.392 322.448C208.458 322.303 208.559 322.081 208.694 321.787C208.965 321.199 209.369 320.322 209.896 319.187C210.952 316.915 212.498 313.613 214.445 309.526C218.343 301.347 223.831 290.06 230.188 277.632C243.118 252.359 258.917 223.821 272.004 206.589C315.733 149.009 351.421 120.819 421.717 79.6416C438.406 69.8655 460.129 59.5063 481.749 50.0439Z"
                                fill="white" stroke="black" stroke-width="40"
                                class="fill-transparent stroke-current" />
                            <path
                                d="M0 30C0 13.4315 13.4315 0 30 0H186.5C199.479 0 210 10.5213 210 23.5C210 36.4787 199.479 47 186.5 47H66C57.7157 47 51 53.7157 51 62V184.5C51 198.583 39.5833 210 25.5 210C11.4167 210 0 198.583 0 184.5V30Z"
                                fill="currentColor" />
                            <path
                                d="M553 523C553 539.569 539.569 553 523 553H366.5C353.521 553 343 542.479 343 529.5C343 516.521 353.521 506 366.5 506H487C495.284 506 502 499.284 502 491V368.5C502 354.417 513.417 343 527.5 343C541.583 343 553 354.417 553 368.5V523Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                    <span class="font-medium text-title-foreground  text-sm tracking-tight flex-1 truncate text-left">
                        UnoSky
                    </span>
                    <x-ui.icon name="ph--caret-up-down" size="none" class="size-5" />
                </div>
            </div>
        </div>
        <div class="px-3 flex flex-col space-y-6 flex-1 overflow-hidden overflow-y-auto py-4 font-normal">
            <ul class="flex flex-col gap-0.5 font-light text-muted-foreground">
                @foreach ($sidebarItems as $item)
                    <x-previews.sidebar.02.sidebar-item :is-active="$item['isActive'] ?? false" :href="$item['href']" :icon="$item['icon']"
                        :text="$item['text']" />
                @endforeach
            </ul>

            <!-- Insights -->
            <div class="space-y-0.5">
                <div class="px-3 mb-2 flex items-center justify-between text-muted-foreground">
                    <span class="text-xs font-medium uppercase tracking-wider">Insights</span>
                    <x-ui.icon name="ph--plus-circle" size="xs"
                        class="cursor-pointer"/>
                </div>
                <ul class="flex flex-col text-muted-foreground">
                    <x-previews.sidebar.02.sidebar-item text="Reporting" href="#" size="xs" icon="ph--radio-button-fill" />
                    <x-previews.sidebar.02.sidebar-item text="Portfolios" href="#" size="xs" icon="ph--radio-button-fill" />
                    <x-previews.sidebar.02.sidebar-item text="Goals" href="#" size="xs" icon="ph--radio-button-fill" />
                </ul>
            </div>

            <!-- Projects -->
            <div class="space-y-0.5">
                <div class="px-3 mb-2 flex items-center justify-between text-muted-foreground">
                    <span class="text-xs font-medium uppercase tracking-wider">Projects</span>
                    <x-ui.icon name="ph--plus-circle" size="xs"
                        class="cursor-pointer"/>
                </div>
                <ul class="flex flex-col gap-0.5 text-muted-foreground">
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 hover:bg-surface fx-active:bg-background fx-current:bg-background border border-transparent fx-active:border-border-input fx-current:border-border-input fx-active:shadow-sm fx-current:shadow-sm fx-active:text-primary group rounded-ui">
                            <div class="size-5 rounded bg-success grid place-content-center text-white">
                                <x-ui.icon name="ph--sparkle" />
                            </div>
                            <span class="font-medium text-sm">Shot 2025</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 hover:bg-surface fx-active:bg-background fx-current:bg-background border border-transparent fx-active:border-border-input fx-current:border-border-input fx-active:shadow-sm fx-current:shadow-sm fx-active:text-primary group rounded-ui">
                            <div class="size-5 rounded bg-warning grid place-content-center text-white">
                                {{-- <x-ui.icon name="ph--hashtag" /> --}}
                                
                            </div>
                            <span class="font-medium text-sm">Sky Showbuzz</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 hover:bg-surface fx-active:bg-background fx-current:bg-background border border-transparent fx-active:border-border-input fx-current:border-border-input fx-active:shadow-sm fx-current:shadow-sm fx-active:text-primary group rounded-ui">
                            <div class="size-5 rounded bg-warning grid place-content-center text-white">
                                <x-ui.icon name="ph--figma-logo" />
                            </div>
                            <span class="font-medium text-sm">Design agency</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Team -->
            <div class="space-y-0.5">
                <div class="px-3 mb-2 flex items-center justify-between text-muted-foreground">
                    <span class="text-xs font-medium uppercase tracking-wider">Team</span>
                    <x-ui.icon name="ph--plus-circle" size="sm" />
                </div>
                <ul class="flex flex-col gap-1.5 text-muted-foreground">
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2 hover:bg-surface fx-active:bg-background fx-current:bg-background border border-transparent fx-active:border-border-input fx-current:border-border-input fx-active:shadow-sm fx-current:shadow-sm fx-active:text-primary group rounded-ui">
                            <x-ui.icon name="ph--users" size="md" />
                            <span class="font-medium text-sm flex-1">My workspace</span>
                            <x-ui.icon name="ph--caret-right" size="xs" />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex w-full">
            <div class="px-3 w-full border-t border-border-input py-2">
                <x-ui.dropdown.trigger size="none" variant="ghost" aria-label="Profile" dropdownId="userProfile"
                    class="gap-3 w-full p-2 border border-border-strong/40">
                    <div class="size-8 min-w-8 rounded-md overflow-hidden">
                        <img class="size-full rounded-md object-cover" src="/avatar1.webp" width="200" height="200"
                            alt="Avatar User" />
                    </div>
                    <div class="flex flex-1 justify-between items-center overflow-hidden">
                        <div class="flex flex-col -space-y-0.5 text-left flex-1">
                            <span class="font-medium text-sm text-title-foreground  line-clamp-1">
                                Johnkat MJ
                            </span>
                            <span class="text-xs text-muted-foreground line-clamp-1">
                                johnkatmj@gmail.com
                            </span>
                        </div>
                        <span aria-hidden="true" class="px-0.5 py-1 flex w-max text-sm">
                            <span class="iconify ph--caret-up-down"></span>
                        </span>
                    </div>
                </x-ui.dropdown.trigger>
                <x-ui.dropdown placement="top-start" class="w-60" id="userProfile">
                    <x-ui.dropdown.header class="flex items-center gap-x-3 px-2 pt-2 pb-1">
                        <img class="size-8 rounded-md object-cover" src="/avatar1.webp" width="200"
                            height="200" alt="Avatar User" />
                        <div class="flex items-start flex-col flex-1">
                            <h4 class="font-semibold text-title-foreground  text-sm">Johnkat MJ</h4>
                            <span class="text-xs text-muted-foreground">johnkatmj@gmail.com</span>
                        </div>
                    </x-ui.dropdown.header>
                    <x-ui.dropdown.separator class="border-border" />
                    <x-ui.dropdown.item href="#">
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--pencil"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            Edit Profile
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item href="#">
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--password"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            Password
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item>
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--wallet"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            Billing
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item intent="danger">
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--sign-out"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            Logout
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                </x-ui.dropdown>
            </div>
        </div>
    </nav>
</x-ui.sidebar-wrapper>
