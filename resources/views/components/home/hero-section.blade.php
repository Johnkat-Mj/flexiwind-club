<section class="relative border-b border-border-strong/70 border-dashed">
    {{-- Pattern strips --}}
    <div class="absolute inset-y-0 left-2 w-28 linear-gradient-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-2 w-28 linear-gradient-pattern opacity-40 pointer-events-none"></div>

    <div class="relative mx-auto flex w-full flex-col items-center px-4 pb-20 pt-20 text-center sm:px-6 lg:max-w-336 lg:px-8 lg:pt-28 lg:pb-28 xl:max-w-352 xl:px-8">
        <a href="/pricing" wire:navigate
            class="inline-flex min-h-8 items-center gap-2 rounded-ui border border-border bg-surface px-3 py-1 text-sm text-muted-foreground shadow-sm transition hover:border-border-strong hover:text-title-foreground">
            <span class="iconify ph--sparkle text-primary"></span>
            Flexiwind Pro is the pro UI layer for Laravel
        </a>

        <h1 class="mt-8 max-w-4xl text-balance text-4xl font-bold tracking-tight text-title-foreground sm:text-5xl lg:text-7xl/[1.06]" style="letter-spacing: -0.03em;">
            Build <span class="font-normal text-muted-foreground">production-ready</span> Laravel <span class="font-normal text-muted-foreground">apps</span> faster.
        </h1>

        <p class="mt-7 max-w-xl text-pretty text-base leading-7 text-muted-foreground sm:text-lg">
            Professional Blade & Livewire sections that you can plug in, customize, and ship with confidence.
        </p>

        <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <x-ui.button href="/pricing" size="lg" wire:navigate>
                <span class="iconify ph--cube mr-2 text-sm"></span>
                Join the club
            </x-ui.button>
            <x-ui.button href="/blocks" variant="outline" intent="gray" size="lg" wire:navigate>
                Browse blocks
                <span class="iconify ph--arrow-right ml-2 text-sm"></span>
            </x-ui.button>
        </div>
    </div>
</section>
