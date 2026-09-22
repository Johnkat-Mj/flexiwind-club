@props(['categories' => []])

<section class="relative border-b border-border-strong/70 border-dashed">
    {{-- Pattern strips --}}
    <div class="absolute inset-y-0 left-2 w-12 linear-gradient-pattern opacity-30 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-2 w-12 linear-gradient-pattern opacity-30 pointer-events-none"></div>

    <div class="relative mx-auto w-full px-4 py-20 sm:px-6 lg:max-w-336 lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        {{-- Header --}}
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-start">
            <div>
                <span class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Library</span>
                <h2 class="mt-3.5 max-w-2xl text-3xl font-bold text-title-foreground sm:text-4xl" style="letter-spacing: -0.02em;">
                    Explore our collection of UI blocks
                </h2>
                <p class="mt-2.5 max-w-md text-sm leading-6 text-muted-foreground">
                    A growing collection of handcrafted Blade and Livewire blocks designed to help you build modern interfaces faster.
                </p>
            </div>
            <x-ui.button href="/blocks" variant="outline" intent="gray" size="sm" wire:navigate class="mt-0 md:mt-10 shrink-0">
                Browse all blocks
                <span class="iconify ph--arrow-up-right ml-1.5"></span>
            </x-ui.button>
        </div>

        {{-- Block grid --}}
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $cat)
                <a href="{{ $cat['href'] }}" wire:navigate
                    class="group overflow-hidden rounded-ui border border-border bg-background shadow-sm transition hover:border-border-strong hover:shadow-md">
                    {{-- Wireframe preview area --}}
                    <div class="flex h-48 items-end p-5">
                        @switch($cat['type'])
                            @case('auth')
                                {{-- Login/Auth wireframe --}}
                                <div class="flex w-full gap-3">
                                    <div class="flex-1 rounded-ui border border-border bg-muted p-3">
                                        <div class="mb-3 h-2 w-16 rounded-full bg-border-strong/60"></div>
                                        <div class="mb-2 h-7 w-full rounded-ui border border-border bg-background"></div>
                                        <div class="mb-3 h-7 w-full rounded-ui border border-border bg-background"></div>
                                        <div class="h-7 w-full rounded-ui bg-primary/80"></div>
                                    </div>
                                </div>
                                @break
                            @case('app')
                                {{-- App layout wireframe --}}
                                <div class="flex w-full gap-2 h-full">
                                    <div class="w-1/4 rounded-ui border border-border bg-muted p-2">
                                        <div class="mb-3 h-1.5 w-10 rounded-full bg-border-strong/60"></div>
                                        <div class="space-y-2">
                                            <div class="h-1.5 w-full rounded-full bg-primary/20"></div>
                                            <div class="h-1.5 w-3/4 rounded-full bg-border"></div>
                                            <div class="h-1.5 w-4/5 rounded-full bg-border"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 rounded-ui border border-border bg-muted p-2">
                                        <div class="mb-2 h-1.5 w-20 rounded-full bg-border-strong/60"></div>
                                        <div class="grid grid-cols-3 gap-1.5">
                                            <div class="h-10 rounded bg-background border border-border"></div>
                                            <div class="h-10 rounded bg-background border border-border"></div>
                                            <div class="h-10 rounded bg-background border border-border"></div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case('data')
                                {{-- Data/table wireframe --}}
                                <div class="w-full rounded-ui border border-border bg-muted p-3">
                                    <div class="mb-3 flex justify-between items-center">
                                        <div class="h-1.5 w-16 rounded-full bg-border-strong/60"></div>
                                        <div class="h-5 w-14 rounded bg-primary/15"></div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex gap-2">
                                            <div class="h-1.5 flex-1 rounded-full bg-border-strong/40"></div>
                                            <div class="h-1.5 flex-1 rounded-full bg-border-strong/40"></div>
                                            <div class="h-1.5 flex-1 rounded-full bg-border-strong/40"></div>
                                        </div>
                                        @for ($i = 0; $i < 3; $i++)
                                            <div class="flex gap-2">
                                                <div class="h-1.5 flex-1 rounded-full bg-border"></div>
                                                <div class="h-1.5 flex-1 rounded-full bg-border"></div>
                                                <div class="h-1.5 flex-1 rounded-full bg-border"></div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                @break
                            @case('marketing')
                                {{-- Marketing wireframe --}}
                                <div class="w-full">
                                    <div class="mb-3 flex gap-2">
                                        <div class="h-1.5 w-10 rounded-full bg-border"></div>
                                        <div class="h-1.5 w-8 rounded-full bg-border"></div>
                                        <div class="h-1.5 w-10 rounded-full bg-border"></div>
                                        <div class="flex-1"></div>
                                        <div class="h-1.5 w-6 rounded-full bg-primary/50"></div>
                                    </div>
                                    <div class="mb-2 h-2.5 w-3/4 rounded-full bg-foreground/70"></div>
                                    <div class="mb-4 h-2.5 w-1/2 rounded-full bg-foreground/70"></div>
                                    <div class="mb-4 h-1.5 w-2/3 rounded-full bg-border"></div>
                                    <div class="flex gap-2">
                                        <div class="h-6 w-16 rounded-md bg-primary/80"></div>
                                        <div class="h-6 w-16 rounded-md border border-border"></div>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>

                    {{-- Label --}}
                    <div class="flex items-center justify-between border-t border-border/60 px-5 py-3.5">
                        <span class="text-sm font-semibold text-title-foreground">{{ $cat['title'] }}</span>
                        <span class="text-xs text-muted-foreground">{{ $cat['count'] }} {{ $cat['count'] === 1 ? 'block' : 'blocks' }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- See all button --}}
        <div class="mt-12 flex justify-center">
            <x-ui.button href="/blocks" variant="outline" intent="gray" size="sm" class="rounded-full px-6" wire:navigate>
                See all blocks
            </x-ui.button>
        </div>
    </div>
</section>
