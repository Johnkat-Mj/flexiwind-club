@php
    $library = [
        [
            'label' => 'Blocks',
            'href' => route('blocks.list'),
            'icon' => 'ph--squares-four',
            'text' => 'Full sections, ready to drop in',
            'active' => 'blocks*',
        ],
        [
            'label' => 'Components',
            'href' => '/components',
            'icon' => 'ph--cube',
            'text' => 'Primitives you compose and own',
            'active' => 'components*',
        ],
        [
            'label' => 'Examples',
            'href' => route('examples'),
            'icon' => 'ph--stack',
            'text' => 'Advanced compositions, ready to copy',
            'active' => 'examples*',
        ],
        [
            'label' => 'Charts',
            'href' => route('charts'),
            'icon' => 'ph--chart-bar',
            'text' => 'Bar, line and pie charts in Blade',
            'active' => 'charts*',
        ],
    ];
    $links = [
        //
        ['label' => 'Docs', 'href' => '/docs', 'active' => 'docs*'],
        [
            'label' => 'Blocks & Components',
            'href' => '/blocks',
            'active' => 'docs*',
            'items' => [
                [
                    'label' => 'Blocks',
                    'href' => route('blocks.list'),
                    'icon' => 'ph--squares-four',
                    'text' => 'Full sections, ready to drop in',
                    'active' => 'blocks*',
                ],
                [
                    'label' => 'Components',
                    'href' => '/components',
                    'icon' => 'ph--cube',
                    'text' => 'Primitives you compose and own',
                    'active' => 'components*',
                ],
                [
                    'label' => 'Examples',
                    'href' => route('examples'),
                    'icon' => 'ph--stack',
                    'text' => 'Advanced compositions, ready to copy',
                    'active' => 'examples*',
                ],
                [
                    'label' => 'Charts',
                    'href' => route('charts'),
                    'icon' => 'ph--chart-bar',
                    'text' => 'Bar, line and pie charts in Blade',
                    'active' => 'charts*',
                ],
            ],
        ],
        ['label' => 'Templates', 'href' => route('pages.templates'), 'active' => 'templates*'],
        ['label' => 'Playground', 'href' => route('playground'), 'active' => 'playground'],
    ];
    $libraryActive = collect($library)->contains(fn(array $item): bool => request()->is($item['active']));
@endphp

<header x-data="{ open: false }" x-on:keydown.escape.window="open = false"
    class="sticky top-0 z-50 border-b border-border bg-background/90 backdrop-blur-md">
    <x-site.container as="nav" aria-label="Main" class="flex h-16 items-center justify-between gap-6 lg:h-18">
        <div class="flex items-center gap-10">
            <a href="/" wire:navigate aria-label="Flexiwind home"
                class="flex items-center gap-2.5 text-title-foreground">
                <x-atoms.logo />
            </a>
            <ul class="hidden items-center gap-7 text-sm text-foreground lg:flex">
                {{-- Sous-menu en CSS pur : il s'ouvre au survol et au focus clavier. --}}

                @foreach ($links as $link)
                    @if (!empty($link['items']))
                        <li class="group/menu relative">
                            <a href="{{ $link['href'] }}" wire:navigate aria-haspopup="true"
                                class="flex items-center gap-1.5 transition-colors group-hover/menu:text-title-foreground group-focus-within/menu:text-title-foreground {{ $libraryActive ? 'font-medium text-title-foreground' : '' }}">
                                {{ $link['label'] }}
                                <span aria-hidden="true"
                                    class="iconify ph--caret-down text-xs transition-transform duration-200 group-hover/menu:rotate-180 group-focus-within/menu:rotate-180"></span>
                            </a>
                            <div
                                class="invisible absolute top-full -left-4 z-50 pt-3 opacity-0 transition-all duration-200 group-hover/menu:visible group-hover/menu:opacity-100 group-focus-within/menu:visible group-focus-within/menu:opacity-100">
                                <ul
                                    class="w-80 translate-y-1 rounded-[14px] border border-border bg-background p-1.5 shadow-[0_20px_40px_-20px_rgba(9,9,11,.35)] transition-transform duration-200 group-hover/menu:translate-y-0 group-focus-within/menu:translate-y-0">
                                    @foreach ($link['items'] as $item)
                                        <li>
                                            <a href="{{ $item['href'] }}" wire:navigate @class([
                                                'flex items-center gap-3 rounded-[10px] p-2 transition-colors hover:bg-subtle focus-visible:bg-subtle focus-visible:outline-none',
                                                'bg-subtle' => request()->is($item['active']),
                                            ])>
                                                <span
                                                    class="flex size-9 shrink-0 items-center justify-center rounded-[10px] border border-border bg-background text-title-foreground">
                                                    <span aria-hidden="true" class="iconify {{ $item['icon'] }}"></span>
                                                </span>
                                                <span class="flex flex-col">
                                                    <span
                                                        class="text-sm font-medium text-title-foreground">{{ $item['label'] }}</span>
                                                    <span
                                                        class="text-xs text-muted-foreground">{{ $item['text'] }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li>
                            <a href="{{ $link['href'] }}" wire:navigate
                                @class([
                                    'transition-colors hover:text-title-foreground',
                                    'font-medium text-title-foreground' => request()->is($link['active']),
                                ])>{{ $link['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="flex items-center gap-2">
            <x-ui.modal.trigger modal-id="search-modal" variant="outline" intent="gray" size="sm" icon-only
                aria-label="Search docs (⌘K)" title="Search · ⌘K" class="rounded-[10px]">
                <span aria-hidden="true" class="iconify ph--magnifying-glass"></span>
            </x-ui.modal.trigger>
            <x-ui.button href="https://github.com/unoforge/flexiwind" variant="outline" intent="gray" size="sm"
                icon-only aria-label="Flexiwind on GitHub" class="hidden rounded-[10px] sm:flex">
                <span aria-hidden="true" class="iconify ph--github-logo"></span>
            </x-ui.button>
            <x-ui.button variant="outline" intent="gray" size="sm" icon-only x-on:click="$store.theme.toggle()"
                aria-label="Toggle theme" class="relative rounded-[10px]">
                <span aria-hidden="true" class="iconify ph--sun absolute hidden dark:flex"></span>
                <span aria-hidden="true" class="iconify ph--moon-stars absolute flex dark:hidden"></span>
            </x-ui.button>

            @auth
                <a href="{{ route('account') }}" wire:navigate
                    class="ml-1 hidden h-8.5 items-center gap-2 rounded-[10px] border border-border pr-3 pl-1.25 text-[13.5px] font-medium text-title-foreground transition-colors hover:bg-surface sm:flex">
                    <x-account.avatar :initials="auth()->user()->initials()" class="size-6 text-[10px]" />
                    Account
                </a>
            @else
                <x-ui.button href="{{ route('login') }}" wire:navigate variant="ghost" intent="gray" size="sm"
                    class="hidden rounded-[10px] px-3 font-medium text-title-foreground sm:flex">
                    Sign in
                </x-ui.button>
                <x-ui.button href="{{ route('pricing') }}" wire:navigate size="sm"
                    class="hidden rounded-[10px] px-3.5 font-medium min-[420px]:flex">
                    Get Pro
                </x-ui.button>
            @endauth

            <x-ui.button variant="outline" intent="gray" size="sm" icon-only x-on:click="open = !open"
                x-bind:aria-expanded="open" aria-controls="site-mobile-nav" aria-label="Open menu"
                class="rounded-[10px] lg:hidden">
                <span aria-hidden="true" class="iconify ph--list" x-show="!open"></span>
                <span aria-hidden="true" class="iconify ph--x" x-show="open" x-cloak></span>
            </x-ui.button>
        </div>
    </x-site.container>

    <div id="site-mobile-nav" x-show="open" x-cloak x-transition.opacity x-on:click.outside="open = false"
        class="absolute inset-x-0 top-full border-b border-border bg-background lg:hidden">
        <x-site.container as="ul" class="flex max-h-[calc(100dvh-4rem)] flex-col overflow-y-auto py-3">
            <li class="pt-1 pb-2 text-xs font-medium tracking-wide text-muted-foreground uppercase">Blocks &amp;
                Components</li>
            <li class="grid grid-cols-2 gap-2 pb-3">
                @foreach ($library as $item)
                    <a href="{{ $item['href'] }}" wire:navigate
                        class="flex items-center gap-2.5 rounded-xl border border-border p-2.5 text-sm font-medium text-title-foreground">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-subtle">
                            <span aria-hidden="true" class="iconify {{ $item['icon'] }}"></span>
                        </span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </li>
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['href'] }}" wire:navigate
                        class="flex h-11 items-center border-t border-border/60 text-[15px] text-title-foreground">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
            @auth
                <li class="pt-3">
                    <x-ui.button href="{{ route('account') }}" wire:navigate variant="outline" intent="gray"
                        class="w-full justify-center gap-2 rounded-[10px]">
                        <x-account.avatar :initials="auth()->user()->initials()" class="size-5.5 text-[9px]" />
                        Account
                    </x-ui.button>
                </li>
            @endauth
            @guest
                <li class="flex gap-2 pt-3">
                    <x-ui.button href="{{ route('login') }}" wire:navigate variant="outline" intent="gray"
                        class="flex-1 justify-center rounded-[10px]">Sign in</x-ui.button>
                    <x-ui.button href="{{ route('pricing') }}" wire:navigate
                        class="flex-1 justify-center rounded-[10px]">
                        Get Pro</x-ui.button>
                </li>
            @endguest
        </x-site.container>
    </div>
</header>
