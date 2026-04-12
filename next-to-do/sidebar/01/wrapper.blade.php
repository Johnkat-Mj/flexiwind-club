<div class="flex-1 flex flex-col h-full bg-bg overflow-hidden relative z-auto">
    <header
        class="h-16 border-b border-border flex items-center justify-between px-4 sm:px-6 shrink-0 bg-bg sticky top-0 z-10">
        <div class="flex items-center gap-3 sm:gap-4">
            <div
                class="flex md:hidden pr-2 relative before:absolute before:inset-y-2 before:right-0 before:w-0.5 before:bg-border">
                <button data-toggle-sidebar
                    class="outline-none aspect-square flex flex-col relative justify-center items-center">
                    <span aria-hidden="true" class="iconify ph--door-open"></span>
                </button>
            </div>
            <h1 class="text-lg font-medium text-fg-title tracking-tight">
                Dashboard
            </h1>
        </div>
        <div class="flex items-center gap-0.5">
            <x-ui.button variant="ghost" size="sm" iconOnly>
                <span class="iconify ph--gear size-4.5"></span>
            </x-ui.button>
            <div class="relative">
                <x-ui.button variant="ghost" size="sm" iconOnly>
                    <span class="iconify ph--bell size-4.5"></span>
                </x-ui.button>
                <span class="absolute top-1.5 right-2 w-2 h-2 bg-danger rounded-full border-2 border-bg"></span>
            </div>
        </div>
    </header>
    <main class="flex-1 overflow-y-auto p-4 sm:p-6">

    </main>
</div>