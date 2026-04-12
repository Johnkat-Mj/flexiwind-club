@php
    $sidebarItems = [
        [
            'id' => '01',
            'text' => 'Dashboard',
            'isActive' => true,
            'href' => '#',
            'icon' => 'ph--squares-four',
        ],
        [
            'id' => '02',
            'text' => 'Inbox',
            'href' => '#',
            'icon' => 'ph--tray',
        ],
        [
            'id' => '03',
            'text' => 'My Tasks',
            'href' => '#',
            'icon' => 'ph--check-square',
        ],
        [
            'id' => '04',
            'text' => 'Projects',
            'icon' => 'ph--folder',
            'items' => [
                [
                    'text' => 'Website Redesign',
                    'href' => '#',
                ],
                [
                    'text' => 'Mobile App',
                    'href' => '#',
                ],
                [
                    'text' => 'API Integration',
                    'href' => '#',
                ],
            ],
        ],
        [
            'id' => '05',
            'text' => 'Reports',
            'href' => '#',
            'icon' => 'ph--chart-bar',
        ],
        [
            'id' => '06',
            'text' => 'Settings',
            'href' => '#',
            'icon' => 'ph--gear',
        ],
    ];
@endphp
<x-ui.sidebar-wrapper
    class="invisible scale-[0.98] opacity-0 fx-open:scale-100 fx-open:visible fx-open:opacity-100
        fixed lg:static z-40 lg:z-auto max-lg:inset-y-0 lg:h-full left-0 flex h-screen max-w-72 w-11/12 sm:max-w-none sm:w-72 origin-left overflow-hidden transition-all duration-300 lg:visible lg:scale-100 lg:opacity-100
        bg-bg lg:bg-transparent
        ">
    <div class="flex flex-col gap-4 py-4 w-full flex-1 overflow-hidden">
        <div class="px-6 h-max flex">
            <span class="size-8 d-flex-place-center bg-linear-to-tr from-primary to-secondary/50 rounded-sm">
                <svg class="size-5 text-white" width="553" height="553" viewBox="0 0 553 553" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M481.749 50.0439C505.676 39.5719 533 57.2231 533 85.3984V138.658C533 159.197 516.518 178.892 492.788 185.605C462.86 194.072 425.008 209.43 397.361 237.488C357.828 277.611 333.78 330.507 309.238 374.237C283.916 419.359 257.031 457.516 211.177 479.877C166.76 501.537 107.535 515.512 61.9404 523.736C40.2339 527.652 20 510.74 20 486.759V449.633C20.0001 428.679 36.1714 411.275 57.0693 409.74L79.0049 408.129C84.3302 407.738 89.5933 406.739 94.6914 405.151L137.944 391.681C143.756 389.871 149.306 387.31 154.455 384.064L159.405 380.943C176.822 369.966 191.117 354.696 200.921 336.605L201.384 335.742L207.755 323.755L208.043 323.212L208.298 322.652L208.301 322.645C208.304 322.637 208.31 322.625 208.317 322.608C208.333 322.574 208.358 322.521 208.392 322.448C208.458 322.303 208.559 322.081 208.694 321.787C208.965 321.199 209.369 320.322 209.896 319.187C210.952 316.915 212.498 313.613 214.445 309.526C218.343 301.347 223.831 290.06 230.188 277.632C243.118 252.359 258.917 223.821 272.004 206.589C315.733 149.009 351.421 120.819 421.717 79.6416C438.406 69.8655 460.129 59.5063 481.749 50.0439Z"
                        fill="white" stroke="black" stroke-width="40" class="fill-transparent stroke-current" />
                    <path
                        d="M0 30C0 13.4315 13.4315 0 30 0H186.5C199.479 0 210 10.5213 210 23.5C210 36.4787 199.479 47 186.5 47H66C57.7157 47 51 53.7157 51 62V184.5C51 198.583 39.5833 210 25.5 210C11.4167 210 0 198.583 0 184.5V30Z"
                        fill="currentColor" />
                    <path
                        d="M553 523C553 539.569 539.569 553 523 553H366.5C353.521 553 343 542.479 343 529.5C343 516.521 353.521 506 366.5 506H487C495.284 506 502 499.284 502 491V368.5C502 354.417 513.417 343 527.5 343C541.583 343 553 354.417 553 368.5V523Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
        <div class="px-6 flex w-full">
            <x-ui.input.group>
                <x-ui.input variant="unstyled" placeholder="Search" class="ps-9 pe-10" />
                <x-ui.input.leading absolute>
                    <span aria-hidden="true" class="iconify ph--magnifying-glass text-fg-muted opacity-80"></span>
                </x-ui.input.leading>
                <x-ui.input.trailing absolute class="[--right-space:4px]">
                    <x-ui.kbd class="text-xs">
                        /
                    </x-ui.kbd>
                </x-ui.input.trailing>
            </x-ui.input.group>
        </div>
        <nav class="px-6 py-4 flex flex-col overflow-hidden overflow-y-auto flex-1">
            <ul class="space-y-1">
                @foreach ($sidebarItems as $item)
                    @if (isset($item['items']))
                        <x-previews.sidebar.01.sidebar-items-group :id="$item['id']" :text="$item['text']" :icon="$item['icon']"
                            :items="$item['items']" />
                    @else
                        <x-previews.sidebar.01.sidebar-item :is-active="$item['isActive'] ?? false" :text="$item['text']" :icon="$item['icon']"
                            :href="$item['href']" />
                    @endif
                @endforeach
            </ul>
            <div class="mt-5">
                <p class="text-fg-muted text-sm font-normal mx-2">
                    Workspaces
                </p>
                <div class="mt-4 space-y-1">
                    <a href="#"
                        class="group flex items-center rounded-ui h-9 justify-start gap-3.5 px-4 text-fg-muted hover:bg-bg-muted/70 hover:text-fg-title">
                        <span class="block size-2 mr-1 rounded-full bg-sky-600 dark:bg-sky-400"></span>
                        <span class="text-sm truncate">Flexiwind Club</span>
                    </a>
                    <a href="#"
                        class="group flex items-center rounded-ui h-9 justify-start gap-3.5 px-4 text-fg-muted hover:bg-bg-muted/70 hover:text-fg-title">
                        <span class="block size-2 mr-1 rounded-full bg-purple-600 dark:bg-purple-400"></span>
                        <span class="text-sm truncate">RK Kit</span>
                    </a>
                    <a href="#"
                        class="group flex items-center rounded-ui h-9 justify-start gap-3.5 px-4 text-fg-muted hover:bg-bg-muted/70 hover:text-fg-title">
                        <span class="block size-2 mr-1 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                        <span class="text-sm truncate">RK UI</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="px-6 flex flex-col h-max space-y-4">
            <div class="flex flex-col p-4 rounded-ui relative ui-soft ui-soft-gray">
                <button aria-label="dismiss panel"
                    class="btn btn-icon-xs btn-ghost btn-ghost-gray absolute right-3 top-3 rounded-ui">
                    <span aria-hidden="true" class="iconify ph--x size-3"></span>
                </button>
                <div class="block text-fg-title font-semibold text-sm">
                    Your credits are out of usage
                </div>
                <p class="text-fg-muted text-sm mt-0.5">
                    Upgrade your plan to get more credits
                </p>

                <div class="mt-2 mb-1">
                    <x-ui.progress size="sm" max="40" value="35" class="text-warning" />
                </div>
                <x-ui.button variant="outline" size="sm" class="w-max">
                    <span class="text-primary">Upgrade plan</span>
                </x-ui.button>
            </div>
            <x-ui.dropdown.trigger variant="ghost" size="md" dropdownId="userProfile"
                class="group px-4 w-full gap-2.5 pl-2" type="button" id="radix-:r0R2h:" aria-haspopup="menu"
                aria-expanded="false">
                <span class="block relative text-sm before:bg-success-600 dark:before:bg-success-400 size-6">
                    <span
                        class="absolute inset-0 m-auto flex items-center justify-center rounded-sm font-medium text-white bg-primary">JK</span>
                </span>
                <span class="text-sm">Johnkat MJ</span>
                <span aria-hidden="true" class="iconify size-3.5 ml-auto ph--caret-up-bold"></span>
                </svg>
            </x-ui.dropdown.trigger>
            <x-ui.dropdown placement="top-start" class="w-60" id="userProfile">
                <x-ui.dropdown.header class="flex items-center gap-x-3 px-2 pt-2 pb-1">
                    <span class="block relative text-sm before:bg-success-600 dark:before:bg-success-400 size-8">
                        <span
                            class="absolute inset-0 m-auto flex items-center justify-center rounded-sm font-medium text-white bg-primary">JK</span>
                    </span>

                    <div class="flex items-start flex-col">
                        <h4 class="font-semibold text-fg-title text-sm">Johnkat MJ</h4>
                        <span class="text-xs text-fg-muted">johnkatmj@gmail.com</span>
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
</x-ui.sidebar-wrapper>
