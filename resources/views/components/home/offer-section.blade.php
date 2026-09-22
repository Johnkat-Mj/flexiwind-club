@php
    $audiences = [
        ['icon' => 'ph--rocket-launch', 'title' => 'Laravel founders', 'description' => 'Launch an MVP that looks funded before you have a design team.'],
        ['icon' => 'ph--users-three', 'title' => 'Agencies', 'description' => 'Deliver polished client interfaces faster while keeping code ownership simple.'],
        ['icon' => 'ph--student', 'title' => 'Builders learning UI', 'description' => 'Study real Blade patterns and understand how professional app screens are assembled.'],
        ['icon' => 'ph--briefcase', 'title' => 'Product teams', 'description' => 'Standardize internal tools, portals and dashboards without starting every screen from zero.'],
    ];
@endphp

<section class="relative border-b border-border-strong/70 border-dashed bg-gray-950 text-white dark:bg-black">
    <div aria-hidden="true" class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(99,102,241,0.28),transparent_34rem)]"></div>
    <div class="relative mx-auto grid w-full gap-10 px-4 py-20 sm:px-6 lg:max-w-336 lg:grid-cols-[1fr_0.9fr] lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div>
            <span class="inline-flex h-7 items-center rounded-ui border border-white/10 bg-white/5 px-2 text-sm text-gray-300">
                Simple offer
            </span>
            <h2 class="mt-4 max-w-2xl text-3xl font-semibold text-white sm:text-5xl/[1.08]">
                One membership. A sharper UI system for every Laravel product.
            </h2>
            <p class="mt-5 max-w-xl text-sm leading-6 text-gray-300">
                Get the premium blocks, templates and implementation patterns that help your next SaaS, admin panel or client portal feel finished from the first screen.
            </p>

            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($audiences as $item)
                    <div class="rounded-ui border border-white/10 bg-white/[0.03] p-4">
                        <span class="iconify {{ $item['icon'] }} text-primary-300"></span>
                        <h3 class="mt-4 font-semibold text-white">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-400">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-white/10 bg-white/[0.04] p-2 shadow-2xl shadow-black/30">
            <div class="rounded-ui border border-white/10 bg-gray-950 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Flexiwind Club</p>
                        <h3 class="mt-1 text-2xl font-semibold text-white">Pro access</h3>
                    </div>
                    <span class="rounded-ui bg-primary px-2 py-1 text-xs font-medium text-white">Best for builders</span>
                </div>
                <div class="mt-7 flex items-end gap-2">
                    <span class="text-5xl font-semibold text-white">$149</span>
                    <span class="pb-2 text-sm text-gray-400">early access</span>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-400">
                    Built for developers who want to ship high UI Laravel applications without hiring a designer for every screen.
                </p>
                <div class="mt-7 flex flex-col gap-3 text-sm text-gray-300">
                    @foreach (['Professional Blade and Livewire-ready blocks', 'Modern templates for real Laravel products', 'AI-friendly markup with clear structure', 'Complete dashboard and app screen patterns', 'Future Club drops included during early access'] as $feature)
                        <span class="flex items-center gap-2">
                            <span class="iconify ph--check text-primary-300"></span>
                            {{ $feature }}
                        </span>
                    @endforeach
                </div>
                <x-ui.button href="/the-club" size="lg" class="mt-8 w-full justify-center" wire:navigate>
                    Get early access
                </x-ui.button>
            </div>
        </div>
    </div>
</section>
