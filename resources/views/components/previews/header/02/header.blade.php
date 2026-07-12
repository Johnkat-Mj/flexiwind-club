<header class="bg-bg border-b border-border flex items-center justify-between px-6 sticky top-0 z-10">
    <div class="w-full max-w-7xl mx-auto flex items-center justify-between py-4">
        <div class="flex h-7 items-center">
            <a href="#" class="text-fg-title flex" aria-label="App Home page">
                <svg class="size-6 text-fg-title" width="553" height="553" viewBox="0 0 553 553" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M481.749 50.0439C505.676 39.5719 533 57.2231 533 85.3984V138.658C533 159.197 516.518 178.892 492.788 185.605C462.86 194.072 425.008 209.43 397.361 237.488C357.828 277.611 333.78 330.507 309.238 374.237C283.916 419.359 257.031 457.516 211.177 479.877C166.76 501.537 107.535 515.512 61.9404 523.736C40.2339 527.652 20 510.74 20 486.759V449.633C20.0001 428.679 36.1714 411.275 57.0693 409.74L79.0049 408.129C84.3302 407.738 89.5933 406.739 94.6914 405.151L137.944 391.681C143.756 389.871 149.306 387.31 154.455 384.064L159.405 380.943C176.822 369.966 191.117 354.696 200.921 336.605L201.384 335.742L207.755 323.755L208.043 323.212L208.298 322.652L208.301 322.645C208.304 322.637 208.31 322.625 208.317 322.608C208.333 322.574 208.358 322.521 208.392 322.448C208.458 322.303 208.559 322.081 208.694 321.787C208.965 321.199 209.369 320.322 209.896 319.187C210.952 316.915 212.498 313.613 214.445 309.526C218.343 301.347 223.831 290.06 230.188 277.632C243.118 252.359 258.917 223.821 272.004 206.589C315.733 149.009 351.421 120.819 421.717 79.6416C438.406 69.8655 460.129 59.5063 481.749 50.0439Z"
                        fill="white" stroke="black" stroke-width="40" class="fill-bg stroke-current" />
                    <path
                        d="M0 30C0 13.4315 13.4315 0 30 0H186.5C199.479 0 210 10.5213 210 23.5C210 36.4787 199.479 47 186.5 47H66C57.7157 47 51 53.7157 51 62V184.5C51 198.583 39.5833 210 25.5 210C11.4167 210 0 198.583 0 184.5V30Z"
                        fill="currentColor" />
                    <path
                        d="M553 523C553 539.569 539.569 553 523 553H366.5C353.521 553 343 542.479 343 529.5C343 516.521 353.521 506 366.5 506H487C495.284 506 502 499.284 502 491V368.5C502 354.417 513.417 343 527.5 343C541.583 343 553 354.417 553 368.5V523Z"
                        fill="currentColor" />
                </svg>
            </a>
            <div class="bg-border w-px h-full rotate-12 sm:block ml-3 mr-2.5"></div>
            <x-ui.dropdown.trigger dropdownId="show-workspaces" variant="soft"
                class="w-full flex items-center gap-2.5 py-1.5 group text-left px-2">
                <div class="max-sm:hidden flex-1 min-w-0 text-nowrap text-fg-muted text-sm font-medium">
                    Sky 243
                </div>
                <span class="iconify size-4 text-fg-muted/80 group-hover:text-fg-muted ph--caret-up-down">
                </span>
            </x-ui.dropdown.trigger>
            <x-ui.dropdown id="show-workspaces" placement="bottom-start" class="w-60">
                <x-ui.dropdown.header class="flex items-center gap-x-3 px-2 pt-2 pb-1">
                    <h4 class="font-semibold text-fg-title text-sm">Workspaces</h4>
                </x-ui.dropdown.header>
                <x-ui.dropdown.separator class="border-border" />
                <x-ui.dropdown.section class="pt-0.5">
                    <x-ui.dropdown.item aria-selected="true">
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--circle"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            UnoForge
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item>
                        <x-ui.dropdown.icon>
                            <span class="iconify ph--circle"></span>
                        </x-ui.dropdown.icon>
                        <x-ui.dropdown.label>
                            RK Kit
                        </x-ui.dropdown.label>
                    </x-ui.dropdown.item>
                </x-ui.dropdown.section>
                <x-ui.dropdown.separator class="border-border" />
                <x-ui.dropdown.section class="pt-0.5">
                    <x-ui.button size="sm" variant="outline"
                        class="col-span-full flex justify-center items-center">
                        <span aria-hidden="true" class="iconify ph--plus-square size-3 mr-2"></span>
                        New workspace
                    </x-ui.button>
                </x-ui.dropdown.section>
            </x-ui.dropdown>
        </div>
        <div class="flex-1 flex justify-end items-center gap-4">
            <div class="relative flex items-center min-w-max">
                <x-ui.button icon-only variant="ghost" size="sm" aria-label="notifications" class="sm:size-9">
                    <x-ui.icon name="ph--bell" />
                </x-ui.button>
                <span class="absolute top-2 right-2 size-2 flex border-2 border-bg bg-danger rounded-full"></span>
            </div>
            <x-ui.dropdown.trigger class="rounded-ui size-max bg-bg-muted" dropdownId="userProfile">
                <x-ui.avatar size="sm" radius="ui" src="/avatar1.webp" height="200" width="200"
                    alt="User avatar" />
            </x-ui.dropdown.trigger>
            <x-ui.dropdown placement="bottom-end" class="w-54" id="userProfile">
                <x-ui.dropdown.header class="flex items-center gap-x-3 px-2 pt-2 pb-1">
                    <x-ui.avatar-placeholder variant="subtle" size="lg" radius="ui">
                        <span class="flex iconify ph--user"></span>
                    </x-ui.avatar-placeholder>

                    <div class="flex items-start flex-col">
                        <h4 class="font-semibold text-fg-title text-sm">Tresor Kasenda</h4>
                        <span class="text-xs text-fg-muted">Web Developer</span>
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
</header>
