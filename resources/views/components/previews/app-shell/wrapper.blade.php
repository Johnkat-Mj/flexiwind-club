<main
    class="overflow-hidden overflow-y-auto h-dvh lg:h-[calc(100dvh---spacing(1))] lg:w-[calc(100vw---spacing(70))] lg:mr-1 lg:mt-1 bg-white dark:bg-gray-900/30 lg:rounded-t-xl lg:border lg:border-b-0 border-border-strong/30 lg:shadow-md lg:shadow-gray-600/10">
    <header class="w-full flex h-15 sticky top-0 z-40 lg:pt-1 border-b border-border-strong/50 bg-bg">
        <div class="flex items-center justify-between w-full h-full px-4">
            <div class="flex items-center gap-3">
                <div
                    class="flex lg:hidden pr-2 relative before:absolute before:inset-y-2 before:right-0 before:w-0.5 before:bg-border">
                    <x-ui.button data-toggle-sidebar variant="soft" size="sm" icon-only class="-ml-2">
                        <span aria-hidden="true" class="iconify ph--door-open"></span>
                    </x-ui.button>
                </div>

                <div class="text-sm">
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.item href="#">
                            <span aria-hidden="true" class="flex iconify ph--house size-3.5"></span>
                        </x-ui.breadcrumbs.item>
                        <x-ui.breadcrumbs.item active>
                            <span aria-hidden="true" class="flex iconify ph--link-break size-3.5 mr-1"></span>
                            Dashboard
                        </x-ui.breadcrumbs.item>
                    </x-ui.breadcrumbs>
                </div>
            </div>
            <div class="flex items-center gap-2"></div>
        </div>
    </header>
    {{ $slot }}
</main>
