<x-site.section grid :pattern="false" class="overflow-hidden">
    <span aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-7 hidden lg:block">
        <span class="relative mx-auto block h-4 max-w-300 px-6">
            <span class="absolute top-0 left-6 size-4 border-t-[1.5px] border-l-[1.5px] border-border-strong"></span>
            <span class="absolute top-0 right-6 size-4 border-t-[1.5px] border-r-[1.5px] border-border-strong"></span>
        </span>
    </span>

    <x-site.container class="pt-12 pb-14 sm:pt-16 sm:pb-16">
        <a href="{{ route('changelog') }}" wire:navigate
            class="inline-flex h-7.5 items-center gap-2 rounded-ui border border-border bg-background pr-[3px] pl-3 text-[13px] font-medium text-foreground shadow-xs transition-colors hover:border-border-strong">
            <span class="size-1.5 rounded-full bg-primary"></span>
            Introducing Flexiwind v1
            <span class="flex h-5.5 items-center rounded-[calc(var(--radius-ui)-4px)] bg-muted/80 px-2 text-title-foreground">
                <span aria-hidden="true" class="iconify ph--arrow-right text-xs"></span>
            </span>
        </a>

        <div class="mt-7 flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between lg:gap-16">
            <h1 class="font-display text-5xl/[1.08] font-semibold tracking-[-0.04em] text-title-foreground sm:text-6xl/[1.08] lg:text-7xl/[1.08]">
                Build louder,<br>
                <span class="text-subtitle">ship</span>
                <span class="relative inline-block px-2.5">
                    sooner
                    <span aria-hidden="true" class="absolute inset-x-0 top-2.5 bottom-1 rounded-xs border-[1.5px] border-dashed border-primary"></span>
                    <span aria-hidden="true" class="absolute top-1.5 -left-1 size-1.75 border-[1.5px] border-primary bg-background"></span>
                    <span aria-hidden="true" class="absolute top-1.5 -right-1 size-1.75 border-[1.5px] border-primary bg-background"></span>
                    <span aria-hidden="true" class="absolute bottom-0 -left-1 size-1.75 border-[1.5px] border-primary bg-background"></span>
                    <span aria-hidden="true" class="absolute -right-1 bottom-0 size-1.75 border-[1.5px] border-primary bg-background"></span>
                    <span aria-hidden="true"
                        class="absolute -bottom-4 -left-px flex h-5.5 items-center rounded-b-[5px] rounded-tr-[5px] bg-primary px-1.75 font-mono text-[11px] font-medium tracking-normal whitespace-nowrap text-primary-foreground">x-ui.heading</span>
                </span><span class="text-subtitle">.</span>
            </h1>

            <div class="flex max-w-110 shrink-0 flex-col gap-6 lg:pb-2">
                <p class="text-[16px]/[1.6] text-pretty text-foreground">
                    One artisan command drops clean Blade and Livewire into your repo, plus a written guide your
                    AI agent reads before it touches a single class.
                </p>
                <div class="flex flex-wrap items-center gap-2.5">
                    <x-ui.button href="{{ route('pricing') }}" wire:navigate
                        class="h-11 gap-2 rounded-[10px] px-4.5 text-[15px] font-medium">
                        Get Full Access
                        <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
                    </x-ui.button>
                    <x-ui.button href="{{ route('blocks.list') }}" wire:navigate variant="outline" intent="gray"
                        class="h-11 rounded-[10px] px-4.5 text-[15px] font-medium text-title-foreground">
                        Explore blocks
                    </x-ui.button>
                </div>
            </div>
        </div>
    </x-site.container>
</x-site.section>
