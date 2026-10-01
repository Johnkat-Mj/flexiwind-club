<x-site.section>
    <x-site.container class="py-16">
        <div class="bg-surface relative flex min-h-105 flex-col items-center justify-center overflow-hidden rounded-3xl border border-border px-6 py-14 text-center">
            <div aria-hidden="true" class="bg-grid absolute inset-0"></div>
            <x-site.corners />
            <span class="relative flex size-14 items-center justify-center rounded-2xl border border-border bg-background text-title-foreground shadow-[0_8px_20px_-10px_rgba(9,9,11,.25)]">
                <x-atoms.logo />
            </span>
            <h2 class="font-display relative mt-6 text-4xl/tight font-semibold tracking-[-0.035em] text-title-foreground sm:text-5xl/[1.12]">
                Your next screen is<br><span class="text-subtitle">one command away.</span>
            </h2>
            <div class="relative mt-7.5 flex flex-wrap justify-center gap-2.5">
                <x-ui.button href="{{ route('pricing') }}" wire:navigate class="h-11.5 gap-2 rounded-[10px] px-5 text-[15px] font-medium">
                    Get Pro <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
                </x-ui.button>
                <x-ui.button href="/docs/introduction" wire:navigate variant="outline" intent="gray"
                    class="h-11.5 rounded-[10px] px-5 text-[15px] font-medium text-title-foreground">Read the docs</x-ui.button>
            </div>
            <x-site.command command="composer require --dev unoforge/flexiwind-cli" class="relative mt-5 w-full max-w-110" />
        </div>
    </x-site.container>
</x-site.section>
