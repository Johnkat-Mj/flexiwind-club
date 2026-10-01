<?php

use App\Support\BlockCatalog;
use Livewire\Component;

new class extends Component
{
    public function with(): array
    {
        $groups = array_map(fn (array $group): array => [
            'key' => $group['key'],
            'category' => $group['category'],
            'title' => $group['title'],
            'description' => $group['description'],
            'free' => $group['free'],
            'pro' => $group['pro'],
            'total' => $group['total'],
            'light' => $group['illustrations']['light'] ?? null,
            'dark' => $group['illustrations']['dark'] ?? $group['illustrations']['light'] ?? null,
            'url' => route('blocks.show', ['blockCategory' => $group['category'], 'blockName' => $group['key']]),
        ], BlockCatalog::groups());

        return [
            'groups' => $groups,
            'totals' => BlockCatalog::totals(),
        ];
    }
};
?>

<main x-data="{
    query: '',
    category: 'all',
    tier: 'all',
    groups: {{ Js::from($groups) }},
    matches(group) {
        const text = (group.title + ' ' + group.description + ' ' + group.key).toLowerCase();
        return (this.category === 'all' || group.category === this.category)
            && (this.tier === 'all' || group[this.tier] > 0)
            && (this.query.trim() === '' || text.includes(this.query.trim().toLowerCase()));
    },
    inCategory(category) {
        return this.groups.filter((group) => group.category === category && this.matches(group));
    },
    get visibleBlocks() {
        return this.groups.filter((group) => this.matches(group))
            .reduce((total, group) => total + (this.tier === 'all' ? group.total : group[this.tier]), 0);
    },
    count(category) {
        return this.groups.filter((group) => category === 'all' || group.category === category)
            .reduce((total, group) => total + group.total, 0);
    },
}" x-on:keydown.window.prevent.meta.k="$refs.search.focus()">
    <x-site.section grid class="overflow-hidden">
        <x-site.container class="flex flex-col items-center pt-14 pb-14 text-center sm:pt-16">
            <x-site.eyebrow icon="ph--squares-four">Blocks</x-site.eyebrow>
            <h1 class="font-display mt-4 text-4xl/tight font-semibold tracking-[-0.04em] text-title-foreground sm:text-[3.5rem]/[1.1]">
                {{ $totals['total'] }} blocks. <span class="text-subtitle">Pick one, ship it.</span>
            </h1>
            <p class="mt-4 max-w-140 text-base/relaxed text-muted-foreground">
                Full sections for Laravel apps and sites — each with a live preview, the Blade source and a one-line install.
            </p>
            <label class="mt-7 flex h-12.5 w-full max-w-140 items-center gap-3 rounded-[14px] border border-border bg-background pr-2 pl-4.5 text-subtitle shadow-[0_1px_2px_rgba(9,9,11,.04),0_12px_30px_-18px_rgba(9,9,11,.2)] focus-within:border-primary focus-within:ring-3 focus-within:ring-primary/15">
                <span aria-hidden="true" class="iconify ph--magnifying-glass"></span>
                <input x-ref="search" x-model="query" type="search" placeholder="Search blocks — login, table, pricing…" aria-label="Search blocks"
                    class="flex-1 bg-transparent text-[15px] text-title-foreground outline-none">
                <x-ui.kbd size="sm" variant="outline" class="font-mono">⌘K</x-ui.kbd>
            </label>
        </x-site.container>
    </x-site.section>

    <x-site.section>
        <x-site.container class="pt-7 pb-20">
            <div class="flex flex-col gap-3 rounded-[14px] border border-border bg-surface p-2.5 sm:flex-row sm:items-center sm:justify-between sm:pl-3.5">
                <div class="flex flex-wrap items-center gap-2 sm:gap-3.5">
                    <div role="tablist" aria-label="Category" class="flex gap-0.5 rounded-[9px] bg-subtle p-0.75">
                        @foreach (['all' => 'All', 'application' => 'Application', 'marketing' => 'Marketing'] as $key => $label)
                            <button type="button" role="tab" x-on:click="category = '{{ $key }}'" x-bind:aria-selected="category === '{{ $key }}'"
                                x-bind:class="category === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                class="flex h-7.5 cursor-pointer items-center gap-1.5 rounded-[7px] px-3 text-[13px] font-medium transition-all">
                                {{ $label }}
                                <span class="font-mono text-[11px] text-subtitle" x-text="count('{{ $key }}')"></span>
                            </button>
                        @endforeach
                    </div>
                    <div role="tablist" aria-label="Tier" class="flex gap-0.5 rounded-[9px] bg-subtle p-0.75">
                        @foreach (['all' => 'All', 'free' => 'Free', 'pro' => 'Pro'] as $key => $label)
                            <button type="button" role="tab" x-on:click="tier = '{{ $key }}'" x-bind:aria-selected="tier === '{{ $key }}'"
                                x-bind:class="tier === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
                <span class="px-1 text-[13.5px] text-muted-foreground" x-text="visibleBlocks + ' blocks'"></span>
            </div>

            @foreach (['application' => 'Application', 'marketing' => 'Marketing'] as $category => $label)
                <div x-show="inCategory('{{ $category }}').length">
                    <div class="mt-10 flex items-baseline justify-between border-b border-border pb-3.5">
                        <h2 class="font-display text-2xl font-semibold tracking-[-0.02em] text-title-foreground">{{ $label }}</h2>
                        <span class="text-[13.5px] text-muted-foreground" x-text="inCategory('{{ $category }}').length + ' groups'"></span>
                    </div>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <template x-for="group in inCategory('{{ $category }}')" :key="group.key">
                            <a x-bind:href="group.url" wire:navigate
                                class="group flex flex-col gap-3 rounded-2xl border border-border bg-background p-1.5 transition-colors hover:border-border-strong">
                                <div class="relative h-50 overflow-hidden rounded-[11px] bg-surface">
                                    <img x-bind:src="group.light" x-bind:alt="group.title + ' blocks preview'" loading="lazy" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02] dark:hidden">
                                    <img x-bind:src="group.dark" x-bind:alt="group.title + ' blocks preview'" loading="lazy" class="hidden size-full object-cover transition-transform duration-300 group-hover:scale-[1.02] dark:block">
                                    <span x-show="group.pro" class="absolute top-2.5 left-2.5 flex h-5.5 items-center gap-1 rounded-full bg-primary px-2 text-[11.5px] font-semibold text-primary-foreground">
                                        <span aria-hidden="true" class="iconify ph--lock-simple text-[11px]"></span>Pro
                                    </span>
                                </div>
                                <div class="flex flex-col gap-0.75 px-2 pb-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[15px] font-semibold text-title-foreground" x-text="group.title"></span>
                                        <span aria-hidden="true" class="iconify ph--arrow-right text-sm text-subtitle transition-transform group-hover:translate-x-0.5"></span>
                                    </div>
                                    <span class="text-[13px] text-muted-foreground"
                                        x-text="group.free + ' free' + (group.pro ? ' · ' + group.pro + ' Pro' : '')"></span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            @endforeach

            <div x-show="visibleBlocks === 0" x-cloak
                class="mt-10 flex h-70 flex-col items-center justify-center gap-2.5 rounded-[18px] border border-dashed border-border-strong text-center">
                <span class="flex size-12 items-center justify-center rounded-full bg-subtle text-title-foreground">
                    <span aria-hidden="true" class="iconify ph--magnifying-glass text-lg"></span>
                </span>
                <span class="text-base font-semibold text-title-foreground">No block matches “<span x-text="query"></span>”</span>
                <span class="text-sm text-muted-foreground">Try another word, or ask for it — we build the most requested ones first.</span>
            </div>
        </x-site.container>
    </x-site.section>

    <x-site.section>
        <x-site.container class="py-10">
            <x-site.request-banner title="Missing a block?" text="Tell us what you are building. The most requested sections ship first."
                action="Request a block" />
        </x-site.container>
    </x-site.section>
</main>
