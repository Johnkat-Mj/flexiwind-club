@php
    $tabs = [
        [
            'id' => 'library',
            'icon' => 'ph--stack',
            'title' => 'Professional Blocks',
            'description' => 'Ready-made sections for high-quality app screens',
            'headline' => 'Ship professional Laravel UI without rebuilding every screen.',
            'meta' => 'Use polished blocks for dashboards, settings, auth, tables and product workflows.',
            'cards' => ['Dashboard blocks', 'Auth screens', 'Data tables'],
            'code' => '<x-flexiwind::blocks.dashboard-kpi />',
        ],
        [
            'id' => 'templates',
            'icon' => 'ph--layout',
            'title' => 'Modern Templates',
            'description' => 'Complete starter screens for real products',
            'headline' => 'Start from a modern template and customize the product faster.',
            'meta' => 'Templates give you the structure for SaaS dashboards, admin panels and client portals.',
            'cards' => ['SaaS dashboard', 'Admin portal', 'Client area'],
            'code' => 'php artisan flexiwind:publish saas-dashboard',
        ],
        [
            'id' => 'ai-friendly',
            'icon' => 'ph--sparkle',
            'title' => 'AI Friendly',
            'description' => 'Readable Blade that assistants can understand and extend',
            'headline' => 'Work faster with AI because the UI code stays clear and composable.',
            'meta' => 'Blocks are structured to be easy to inspect, explain, modify and reuse with AI coding tools.',
            'cards' => ['Clear markup', 'Named sections', 'Composable parts'],
            'code' => 'Ask AI: adapt this block for a billing settings page',
        ],
    ];

    $sideItems = [
        ['icon' => 'ph--house', 'label' => 'Dashboard', 'active' => true],
        ['icon' => 'ph--squares-four', 'label' => 'Blocks', 'active' => false],
        ['icon' => 'ph--layout', 'label' => 'Templates', 'active' => false],
        ['icon' => 'ph--sparkle', 'label' => 'AI notes', 'active' => false],
    ];
@endphp

<section class="relative border-b border-border-strong/70 border-dashed bg-bg">
    <div class="mx-auto flex w-full flex-col px-4 pb-14 pt-16 sm:px-6 md:pb-20 lg:max-w-336 lg:px-8 lg:pt-24 xl:max-w-352 xl:px-8">
        <div class="mx-auto flex max-w-4xl flex-col items-center text-center">
            <a href="/the-club" wire:navigate
                class="inline-flex min-h-8 items-center gap-2 rounded-ui border border-border bg-surface px-3 py-1 text-sm text-muted-foreground shadow-sm transition hover:border-border-strong hover:text-title-foreground ">
                <span class="iconify ph--sparkle text-primary"></span>
                Flexiwind Club is the pro UI layer for Laravel
            </a>

            <h1 class="mt-7 max-w-4xl text-balance text-4xl font-semibold tracking-normal text-title-foreground  sm:text-5xl lg:text-7xl/[1.03]">
                Build polished Laravel apps in days, not design sprints.
            </h1>

            <p class="mt-6 max-w-2xl text-pretty text-base leading-7 text-muted-foreground sm:text-lg">
                Professional blocks, modern templates and AI-friendly Blade for developers who want to build high-end Laravel interfaces faster.
            </p>

            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <x-ui.button href="/the-club" size="lg" wire:navigate>
                    <span class="iconify ph--cube mr-2 text-sm"></span>
                    Join the club
                </x-ui.button>
                <x-ui.button href="/blocks" variant="outline" intent="gray" size="lg" wire:navigate>
                    Browse blocks
                    <span class="iconify ph--arrow-right ml-2 text-sm"></span>
                </x-ui.button>
            </div>
        </div>

        <div class="mx-auto mt-12 w-full max-w-7xl">
            <x-ui.tabs class="gap-6">
                <x-ui.tabs.list unStyled
                    class="mx-auto flex w-full max-w-3xl flex-col gap-2 rounded-2xl border border-border bg-surface p-1 shadow-sm sm:flex-row">
                    @foreach ($tabs as $tab)
                        <x-ui.tabs.trigger :id="$tab['id']" unStyled
                            class="group flex min-h-14 flex-1 items-center gap-3 rounded-xl px-3 py-3 text-left transition fx-active:bg-background fx-active:shadow-sm hover:bg-bg/70">
                            <span
                                class="flex size-9 shrink-0 items-center justify-center rounded-ui border border-border bg-background text-base text-muted-foreground transition group-[.fx-active]:border-primary-200 group-[.fx-active]:bg-primary-50 group-[.fx-active]:text-primary dark:group-[.fx-active]:border-primary-900 dark:group-[.fx-active]:bg-primary-950/30">
                                <span class="iconify {{ $tab['icon'] }}"></span>
                            </span>
                            <span class="min-w-0">
                                <span class="flex flex-wrap items-center gap-2">
                                    <span class="text-sm font-semibold text-title-foreground ">{{ $tab['title'] }}</span>
                                </span>
                                <span class="mt-0.5 hidden text-xs leading-5 text-muted-foreground sm:block">{{ $tab['description'] }}</span>
                            </span>
                        </x-ui.tabs.trigger>
                    @endforeach
                </x-ui.tabs.list>

                <x-ui.tabs.panel-wrapper>
                    @foreach ($tabs as $tab)
                        <x-ui.tabs.panel :id="$tab['id']" :active="$loop->first" class="w-full">
                            <div class="overflow-hidden rounded-[1.75rem] border border-border-strong/70 bg-surface shadow-2xl shadow-gray-950/10 dark:shadow-black/40">
                                <div class="flex h-14 items-center justify-between border-b border-border bg-background px-4 sm:px-5">
                                    <div class="flex items-center gap-2">
                                        <span class="size-2.5 rounded-full bg-danger-400"></span>
                                        <span class="size-2.5 rounded-full bg-warning-400"></span>
                                        <span class="size-2.5 rounded-full bg-success-400"></span>
                                    </div>
                                    <div class="hidden h-8 min-w-72 items-center justify-center gap-2 rounded-full border border-border bg-muted px-4 text-sm text-muted-foreground sm:flex">
                                        <span class="iconify ph--lock-key"></span>
                                        club.flexiwind.dev/{{ $tab['id'] }}
                                    </div>
                                    <div class="flex items-center gap-3 text-xl text-muted-foreground">
                                        <span class="iconify ph--arrow-clockwise"></span>
                                        <span class="iconify ph--plus"></span>
                                    </div>
                                </div>

                                <div class="grid min-h-[32rem] bg-background md:grid-cols-[15rem_1fr] lg:min-h-[38rem]">
                                    <aside class="hidden border-r border-border bg-subtle/50 p-5 md:block">
                                        <div class="mb-6 flex items-center gap-3">
                                            <span class="flex size-10 items-center justify-center rounded-xl bg-primary text-xl text-white">
                                                <span class="iconify ph--cube"></span>
                                            </span>
                                            <div>
                                                <p class="text-sm font-semibold text-title-foreground ">Flexiwind Club</p>
                                                <p class="text-xs text-muted-foreground">Club workspace</p>
                                            </div>
                                        </div>
                                        <div class="rounded-ui border border-border bg-background px-3 py-2 text-sm text-muted-foreground">
                                            <span class="iconify ph--magnifying-glass mr-2"></span>
                                            Search blocks...
                                        </div>
                                        <nav class="mt-5 flex flex-col gap-1">
                                            @foreach ($sideItems as $item)
                                                <span @class([
                                                    'flex h-9 items-center gap-2 rounded-ui px-3 text-sm',
                                                    'bg-primary-50 text-primary dark:bg-primary-950/30' => $item['active'],
                                                    'text-muted-foreground' => ! $item['active'],
                                                ])>
                                                    <span class="iconify {{ $item['icon'] }}"></span>
                                                    {{ $item['label'] }}
                                                </span>
                                            @endforeach
                                        </nav>
                                    </aside>

                                    <div class="p-4 sm:p-6 lg:p-8">
                                        <div class="flex flex-col justify-between gap-5 border-b border-border pb-6 sm:flex-row sm:items-start">
                                            <div>
                                                <p class="text-sm text-muted-foreground">{{ $tab['description'] }}</p>
                                                <h2 class="mt-1 max-w-2xl text-2xl font-semibold text-title-foreground ">{{ $tab['headline'] }}</h2>
                                                <p class="mt-2 max-w-xl text-sm leading-6 text-muted-foreground">{{ $tab['meta'] }}</p>
                                            </div>
                                            <x-ui.button href="/the-club" size="sm" wire:navigate>
                                                Preview access
                                            </x-ui.button>
                                        </div>

                                        <div class="mt-6 grid gap-4 lg:grid-cols-3">
                                            @foreach ($tab['cards'] as $card)
                                                <div class="rounded-ui border border-border bg-surface p-4">
                                                    <div class="flex h-28 items-end rounded-ui border border-border bg-muted p-3">
                                                        <div class="grid w-full grid-cols-4 gap-1.5">
                                                            <span class="h-10 rounded bg-bg"></span>
                                                            <span class="h-16 rounded bg-bg"></span>
                                                            <span class="h-12 rounded bg-bg"></span>
                                                            <span class="h-20 rounded bg-primary/15"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 h-3 w-2/3 rounded-full bg-border-strong/60"></div>
                                                    <div class="mt-2 h-3 w-1/2 rounded-full bg-border"></div>
                                                    <p class="mt-4 text-sm font-medium text-title-foreground ">{{ $card }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-6 rounded-ui border border-border bg-surface p-4">
                                            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                                                <div>
                                                    <p class="text-sm font-medium text-title-foreground ">Copy-ready implementation</p>
                                                    <p class="mt-1 text-sm text-muted-foreground">Readable Blade, clear sections and ready UI structure you can adapt quickly.</p>
                                                </div>
                                                <span class="hidden rounded-ui bg-success-50 px-2 py-1 text-xs font-medium text-success-700 dark:bg-success-950/30 dark:text-success-300 sm:inline-flex">Ready</span>
                                            </div>
                                            <div class="mt-4 rounded-ui border border-border bg-background px-3 py-3 font-mono text-xs text-muted-foreground">
                                                {{ $tab['code'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-ui.tabs.panel>
                    @endforeach
                </x-ui.tabs.panel-wrapper>
            </x-ui.tabs>
        </div>
    </div>
</section>
