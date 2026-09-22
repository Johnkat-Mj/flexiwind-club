<header class="sticky top-0 h-15 flex items-center bg-background z-70">
    <span class="absolute bottom-0 inset-x-0 h-px linear-bg-horizontal"></span>
    <x-atoms.container as="nav" class="h-full flex justify-between items-center">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <button data-toggle-nav="yourNavbarId" aria-label="Toggle navbar" class="lg:hidden">
                    <!-- Hamburger icon -->
                </button>
                <a href="/">
                    <x-atoms.logo />
                </a>
            </div>
            <div x-data x-navbar id="yourNavbarId" class="flex">
                <x-molecules.nav-items />
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.modal.trigger modal-id="search-modal" size="sm" iconOnly variant="ghost" intent="gray"
                class="border border-input">
                <span class="iconify ph--magnifying-glass text-sm"></span>
            </x-ui.modal.trigger>
            <x-ui.button href="https://github.com/unoforge/flexiwind" variant="ghost" intent="gray"
                class="border border-input" size="sm" iconOnly>
                <span class="iconify ph--github-logo"></span>
            </x-ui.button>
            <x-ui.button variant="ghost" size="sm" iconOnly radius="none" x-on:click="$store.theme.toggle()"
                aria-label="toggle theme" class="relative border border-input">
                <span
                    class="absolute top-1/2 -translate-1/2 left-1/2 ease-linear duration-200 iconify ph--sun invisible dark:visible"></span>
                <span
                    class="absolute top-1/2 -translate-1/2 left-1/2 ease-linear duration-200 iconify ph--moon-stars visible dark:invisible"></span>
            </x-ui.button>
            <x-atoms.ui-link href="/the-club" aria-label="Link to club page"
                class="ml-1.5 btn h-8 text-sm px-3 btn-solid btn-solid-neutral rounded-ui text-bg max-[350px]:hidden"
                wire:navigate>
                <span class="iconify ph--cube text-xs mr-1 hidden min-[560px]:flex"></span>
                Get all access
            </x-atoms.ui-link>
        </div>
    </x-atoms.container>
</header>
