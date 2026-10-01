@php
    $entries = config('changelog');
    $kinds = [
        'Added' => 'bg-emerald-600/13 text-emerald-700 dark:text-emerald-400',
        'Changed' => 'bg-blue-600/13 text-blue-700 dark:text-blue-300',
        'Fixed' => 'bg-amber-600/13 text-amber-700 dark:text-amber-400',
    ];
    $tagLabels = ['components' => 'Components', 'blocks' => 'Blocks', 'cli' => 'CLI', 'docs' => 'Docs', 'pro' => 'Pro'];
@endphp

<x-layouts::site>
    <main x-data="{ tag: 'all' }">
        <x-site.section grid class="overflow-hidden">
            <x-site.container class="flex flex-col items-start pt-14 pb-10 sm:pt-15">
                <x-site.eyebrow icon="ph--sparkle">Changelog</x-site.eyebrow>
                <h1 class="font-display mt-3.5 text-4xl/tight font-semibold tracking-[-0.04em] text-title-foreground sm:text-[3.5rem]/[1.1]">
                    What's new <span class="text-subtitle">in Flexiwind.</span>
                </h1>
                <p class="mt-3 max-w-140 text-base/relaxed text-muted-foreground">
                    New components, blocks and tooling, shipped in the open. Every entry follows Keep a Changelog.
                </p>
                <div class="mt-6 flex w-full flex-wrap items-center justify-between gap-3">
                    <div role="tablist" aria-label="Filter" class="flex max-w-full gap-0.5 overflow-x-auto rounded-[10px] bg-subtle p-0.75">
                        @foreach (['all' => 'All', ...$tagLabels] as $key => $label)
                            <button type="button" role="tab" x-on:click="tag = '{{ $key }}'" x-bind:aria-selected="tag === '{{ $key }}'"
                                x-bind:class="tag === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                class="h-7.5 shrink-0 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                        @endforeach
                    </div>
                    <x-ui.button href="https://github.com/unoforge/flexiwind" variant="outline" intent="gray"
                        class="h-9.5 gap-2 rounded-[10px] px-3.5 font-medium text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--github-logo"></span>Follow on GitHub
                    </x-ui.button>
                </div>
            </x-site.container>
        </x-site.section>

        <x-site.section>
            <x-site.container>
                @foreach ($entries as $entry)
                    <article x-show="tag === 'all' || {{ Js::from($entry['tags']) }}.includes(tag)"
                        class="grid gap-5 border-b border-border py-11 last:border-0 lg:grid-cols-[220px_minmax(0,1fr)] lg:gap-10">
                        <div class="flex items-center gap-3 lg:flex-col lg:items-start lg:gap-2.5">
                            <span @class([
                                'flex h-7 items-center rounded-lg px-2.5 font-mono text-[13px] font-medium',
                                'bg-primary text-primary-foreground' => $entry['version'] === 'Unreleased',
                                'bg-gray-900 text-white dark:bg-white dark:text-gray-950' => $entry['version'] !== 'Unreleased',
                            ])>{{ $entry['version'] }}</span>
                            <span class="text-sm text-muted-foreground">{{ $entry['date'] }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="font-display text-[26px]/[1.2] font-semibold tracking-[-0.025em] text-title-foreground sm:text-3xl/9">{{ $entry['title'] }}</h2>
                            <p class="mt-2.5 max-w-170 text-base/relaxed text-muted-foreground">{{ $entry['summary'] }}</p>
                            <div class="mt-3.5 flex flex-wrap gap-1.5">
                                @foreach ($entry['tags'] as $entryTag)
                                    <span class="flex h-6 items-center rounded-full border border-border px-2.25 text-xs text-foreground">{{ $tagLabels[$entryTag] }}</span>
                                @endforeach
                            </div>
                            <div class="bg-dots relative mt-6 h-70 overflow-hidden rounded-[18px] border border-border bg-surface">
                                <x-dynamic-component :component="'changelog.'.$entry['visual']" />
                            </div>
                            <div class="mt-5.5 flex flex-col">
                                @foreach ($entry['changes'] as $kind => $items)
                                    @foreach ($items as $item)
                                        <div class="flex items-start gap-3 border-t border-border/60 py-2.5">
                                            <span class="w-18.5 shrink-0">
                                                <span class="inline-flex h-5.5 items-center rounded-md px-2 text-[11.5px] font-semibold {{ $kinds[$kind] }}">{{ $kind }}</span>
                                            </span>
                                            <span class="text-[14.5px]/5.5 text-foreground">{{ $item }}</span>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </x-site.container>
        </x-site.section>
    </main>
</x-layouts::site>
