<section class="relative bg-gray-950 text-white dark:bg-black">
    <div aria-hidden="true" class="absolute inset-x-0 top-0 h-96 bg-[radial-gradient(ellipse_at_50%_0%,rgba(2,132,199,0.22),transparent_22rem)]"></div>
    <div class="relative mx-auto flex w-full flex-col items-center px-4 py-20 text-center sm:px-6 lg:max-w-336 lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div class="flex size-12 items-center justify-center rounded-xl border border-white/10 bg-white/[0.06]">
            <x-atoms.site-logo class="!size-6 !text-white" />
        </div>

        <h2 class="mt-7 max-w-md text-3xl font-bold text-white sm:text-4xl" style="letter-spacing: -0.02em;">
            Ready to build amazing UIs?
        </h2>

        <p class="mt-4 max-w-sm text-base leading-7 text-gray-400">
            Join developers building beautiful Laravel interfaces with Flexiwind Club.
        </p>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <x-ui.button href="/the-club" size="lg" variant="outline" class="border-white/20 bg-white text-gray-950 hover:bg-gray-100" wire:navigate>
                Start for free
                <span class="iconify ph--arrow-right ml-2 text-sm"></span>
            </x-ui.button>
        </div>
    </div>
</section>
