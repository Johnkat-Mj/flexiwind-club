@php
    $included = [
        ['icon' => 'ph--layout', 'title' => 'Complete app screens', 'description' => 'Sidebar layouts, settings pages, profile flows and product dashboards.'],
        ['icon' => 'ph--squares-four', 'title' => 'Composable blocks', 'description' => 'Headers, heroes, feature grids, tables, cards, forms, modals and CTAs.'],
        ['icon' => 'ph--layout', 'title' => 'Modern templates', 'description' => 'Ready screens for dashboards, portals, settings, billing and client areas.'],
        ['icon' => 'ph--terminal-window', 'title' => 'Production code', 'description' => 'Markup built to copy, paste, read and maintain in real Laravel projects.'],
        ['icon' => 'ph--cursor-click', 'title' => 'Interactive components', 'description' => 'Dropdowns, dialogs, selects, autocomplete and sidebar primitives shaped for app UIs.'],
        ['icon' => 'ph--book-open-text', 'title' => 'Implementation notes', 'description' => 'Guidance for adapting blocks to your domain without losing the design quality.'],
    ];
@endphp

<section class="relative border-b border-border-strong/70 border-dashed bg-subtle/50">
    <div class="mx-auto w-full px-4 py-20 sm:px-6 lg:max-w-336 lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="inline-flex h-7 items-center rounded-ui border border-border bg-background px-2 text-sm text-muted-foreground">
                What you get
            </span>
            <h2 class="mt-4 text-3xl font-semibold text-title-foreground  sm:text-4xl">
                Everything you need to make Laravel look premium.
            </h2>
            <p class="mt-4 text-sm leading-6 text-muted-foreground">
                Not starter kits. Not screenshots. Real UI pieces shaped for high-quality products.
            </p>
        </div>

        <div class="mt-12 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($included as $item)
                <div class="rounded-ui border border-border bg-background p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-ui bg-muted text-primary">
                            <span class="iconify {{ $item['icon'] }}"></span>
                        </div>
                        <h3 class="font-semibold text-title-foreground ">{{ $item['title'] }}</h3>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-muted-foreground">{{ $item['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
