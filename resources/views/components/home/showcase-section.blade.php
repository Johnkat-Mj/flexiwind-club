@php
    $showcase = [
        ['image' => '/illustrations/shell-light.webp', 'darkImage' => '/illustrations/shell-dark.webp', 'title' => 'App shells', 'description' => 'Navigation structures for SaaS dashboards, portals and admin products.'],
        ['image' => '/illustrations/table-light.webp', 'darkImage' => '/illustrations/table-dark.webp', 'title' => 'Data surfaces', 'description' => 'Tables, activity feeds, KPIs and dense screens that remain calm and scannable.'],
        ['image' => '/illustrations/components-light.webp', 'darkImage' => '/illustrations/components-dark.webp', 'title' => 'UI primitives', 'description' => 'Buttons, menus, popovers, modals, selects and form building blocks.'],
    ];
@endphp

<section class="border-b border-border-strong/70 border-dashed">
    <div class="mx-auto w-full px-4 py-20 sm:px-6 lg:max-w-336 lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <span class="inline-flex h-7 items-center rounded-ui border border-border bg-surface px-2 text-sm text-muted-foreground">
                    Component library
                </span>
                <h2 class="mt-4 max-w-2xl text-3xl font-semibold text-title-foreground  sm:text-4xl">
                    Meticulously crafted sections for app builders.
                </h2>
            </div>
            <x-ui.button href="/templates" variant="outline" intent="gray" size="sm" wire:navigate>
                View templates
                <span class="iconify ph--arrow-right ml-2"></span>
            </x-ui.button>
        </div>

        <div class="mt-10 grid gap-4 lg:grid-cols-3">
            @foreach ($showcase as $item)
                <article class="overflow-hidden rounded-ui border border-border bg-surface shadow-sm">
                    <div class="border-b border-border bg-muted p-3">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }} preview"
                            class="block aspect-[16/10] w-full rounded-ui border border-border bg-background object-cover dark:hidden">
                        <img src="{{ $item['darkImage'] }}" alt="{{ $item['title'] }} preview in dark mode"
                            class="hidden aspect-[16/10] w-full rounded-ui border border-border bg-background object-cover dark:block">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-title-foreground ">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-muted-foreground">{{ $item['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
