@php
    $isFree = $template['tier'] === 'free';
    $next = $others[0] ?? null;
    $host = $template['key'] === 'crm' ? 'acme.test/crm' : 'unoplanner.test';
    $facts = [
        ['Price', $isFree ? 'Free, open source' : 'Paid'],
        ['Pages', count($template['inside']).' app pages'],
        ['Built with', implode(' · ', $template['stack'])],
        ['Themes', 'Light and dark'],
        ['Source', 'Yours, in your repo'],
    ];
@endphp

<x-layouts::site>
    <main>
        <x-site.section>
            <x-site.container class="flex min-h-14 items-center justify-between gap-3 py-2.5">
                <nav aria-label="Breadcrumb" class="flex min-w-0 items-center gap-2 text-sm">
                    <a href="{{ route('pages.templates') }}" wire:navigate class="text-muted-foreground hover:text-title-foreground">Templates</a>
                    <span aria-hidden="true" class="iconify ph--caret-right shrink-0 text-xs text-border-strong"></span>
                    <span class="truncate font-medium text-title-foreground">{{ $template['title'] }}</span>
                </nav>
                <div class="flex shrink-0 items-center gap-2">
                    <x-ui.button href="{{ route('pages.templates') }}" wire:navigate variant="ghost" intent="gray" size="sm"
                        class="hidden h-8 gap-1.5 rounded-[10px] px-3 text-[13px] sm:flex">
                        <span aria-hidden="true" class="iconify ph--layout"></span>All templates
                    </x-ui.button>
                    @if ($next)
                        <x-ui.button href="{{ route('templates.show', $next['key']) }}" wire:navigate variant="outline" intent="gray" size="sm"
                            class="h-8 gap-1.5 rounded-[10px] px-3 text-[13px] font-medium text-title-foreground">
                            {{ $next['title'] }}<span aria-hidden="true" class="iconify ph--caret-right text-xs"></span>
                        </x-ui.button>
                    @endif
                </div>
            </x-site.container>
        </x-site.section>

        <x-site.section grid class="overflow-hidden">
            <x-site.container class="grid gap-10 pt-12 pb-12 sm:pt-14 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-end">
                <div class="flex flex-col items-start">
                    <x-site.eyebrow icon="ph--layout">Template · {{ $template['category'] }}</x-site.eyebrow>
                    <h1 class="font-display mt-3.5 text-4xl/tight font-semibold tracking-[-0.04em] text-title-foreground sm:text-[3.25rem]/[1.1]">{{ $template['title'] }}</h1>
                    <p class="mt-3 max-w-150 text-base/relaxed text-pretty text-muted-foreground">{{ $template['description'] }}</p>
                    <div class="mt-7 flex flex-wrap gap-2.5">
                        @if ($isFree)
                            <x-ui.button :href="$template['url']" class="h-11 gap-2 rounded-[10px] px-4.5 font-medium">
                                <span aria-hidden="true" class="iconify ph--github-logo"></span>Use the template
                            </x-ui.button>
                        @else
                            <x-ui.button href="{{ route('pricing') }}" wire:navigate class="h-11 gap-2 rounded-[10px] px-4.5 font-medium">
                                <span aria-hidden="true" class="iconify ph--download-simple"></span>Get the template
                            </x-ui.button>
                        @endif
                        <x-ui.button href="#preview" variant="outline" intent="gray" class="h-11 rounded-[10px] px-4.5 font-medium text-title-foreground">
                            Try it below
                        </x-ui.button>
                    </div>
                </div>
                <dl class="divide-y divide-border rounded-[18px] border border-border bg-background px-5 shadow-xs">
                    @foreach ($facts as [$label, $value])
                        <div class="flex items-center justify-between gap-4 py-3 text-sm">
                            <dt class="text-muted-foreground">{{ $label }}</dt>
                            <dd class="text-right font-medium text-title-foreground">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-site.container>
        </x-site.section>

        {{-- Démo interactive --}}
        <x-site.section id="preview" class="scroll-mt-20">
            <x-site.container class="py-10">
                <div x-data="previewTheme" x-on:demo-page.window="page = $event.detail.page"
                    x-init="page = @js($template['inside'][0]['page'])"
                    class="overflow-hidden rounded-[18px] border border-border bg-background shadow-[0_1px_2px_rgba(9,9,11,.04),0_40px_80px_-40px_rgba(9,9,11,.28)]">
                    <div class="flex h-11 items-center justify-between gap-3 border-b border-border px-3.5">
                        <div class="hidden w-40 gap-1.5 md:flex">
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                        </div>
                        <div class="flex h-7 w-full max-w-75 items-center justify-center gap-1.5 rounded-lg border border-border/60 bg-surface font-mono text-xs text-muted-foreground">
                            <span aria-hidden="true" class="iconify ph--lock-simple text-xs"></span>
                            <span class="truncate">{{ $host }}/<span x-text="page"></span></span>
                        </div>
                        <div class="flex w-40 items-center justify-end gap-2">
                            <span class="hidden text-xs text-muted-foreground sm:inline">Live preview</span>
                            <div class="flex gap-0.5 rounded-lg bg-subtle p-0.5">
                                @foreach (['light' => 'ph--sun', 'dark' => 'ph--moon'] as $mode => $icon)
                                    <button type="button" x-on:click="preference = '{{ $mode }}'" aria-label="{{ ucfirst($mode) }} preview"
                                        x-bind:class="(preference === '{{ $mode }}' || (preference === 'system' && isDark === {{ $mode === 'dark' ? 'true' : 'false' }})) ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                        class="flex h-6 w-6.5 cursor-pointer items-center justify-center rounded-md">
                                        <span aria-hidden="true" class="iconify {{ $icon }} text-xs"></span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div x-bind:class="isDark ? 'dark' : 'light'" class="h-170">
                        @if ($template['demo'] === 'crm')
                            <x-demo.crm />
                        @else
                            <x-demo.starter />
                        @endif
                    </div>
                </div>
            </x-site.container>
        </x-site.section>

        {{-- Contenu --}}
        <x-site.section>
            <x-site.container class="py-20 lg:py-24">
                <x-site.section-heading icon="ph--package" eyebrow="What's inside"
                    :title="([4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight'][count($template['inside'])] ?? count($template['inside'])).' pages,'" muted="ready on day one.">
                    Each page is plain Blade built from the same components as the rest of your app. Open one in the preview above.
                </x-site.section-heading>
                <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($template['inside'] as $item)
                        <a href="#preview" x-on:click="$dispatch('demo-go', @js($item['page']))"
                            class="group flex flex-col gap-3 rounded-[18px] border border-border bg-background p-5 transition-colors hover:border-border-strong">
                            <span class="flex size-10 items-center justify-center rounded-[11px] bg-primary/10 text-primary">
                                <span aria-hidden="true" class="iconify {{ $item['icon'] }} text-lg"></span>
                            </span>
                            <span class="flex flex-col gap-1">
                                <span class="text-base font-semibold text-title-foreground">{{ $item['title'] }}</span>
                                <span class="text-sm text-muted-foreground">{{ $item['text'] }}</span>
                            </span>
                            <span class="mt-auto flex items-center gap-1.5 pt-1 text-[13px] font-medium text-primary">
                                Open in the preview<span aria-hidden="true" class="iconify ph--arrow-right text-xs transition-transform group-hover:translate-x-0.5"></span>
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                    @foreach ([
                        ['ph--hand-heart', 'Your code, all of it', 'The whole application lands in your repository. Rename, restyle, delete — nothing phones home.'],
                        ['ph--squares-four', 'The components you know', 'Every screen reuses Flexiwind primitives and blocks, so extending it feels like the rest of your app.'],
                        ['ph--sun', 'Light and dark', 'Both themes are built in and read the same tokens as the components.'],
                    ] as [$icon, $title, $text])
                        <div class="flex gap-4 rounded-[18px] border border-border bg-surface p-5">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-[11px] border border-border bg-background text-title-foreground">
                                <span aria-hidden="true" class="iconify {{ $icon }} text-lg"></span>
                            </span>
                            <span class="flex flex-col gap-1">
                                <span class="text-[15px] font-semibold text-title-foreground">{{ $title }}</span>
                                <span class="text-sm/relaxed text-muted-foreground">{{ $text }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-site.container>
        </x-site.section>

        @if ($others !== [])
            <x-site.section>
                <x-site.container class="py-16">
                    <div class="flex items-baseline justify-between border-b border-border pb-3.5">
                        <h2 class="font-display text-2xl font-semibold tracking-[-0.02em] text-title-foreground">Also worth a look</h2>
                        <a href="{{ route('pages.templates') }}" wire:navigate class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground hover:text-title-foreground">
                            All templates<span aria-hidden="true" class="iconify ph--arrow-right text-xs"></span>
                        </a>
                    </div>
                    <div class="mt-6 flex flex-col gap-6">
                        @foreach ($others as $other)
                            <x-site.template-card :template="$other" />
                        @endforeach
                    </div>
                </x-site.container>
            </x-site.section>
        @endif
    </main>
</x-layouts::site>
