<?php

use App\Support\BlockCatalog;
use Livewire\Component;

new class extends Component
{
    public string $category;

    public string $blockName;

    public function mount(string $blockCategory, string $blockName): void
    {
        $this->category = $blockCategory;
        $this->blockName = $blockName;
    }

    public function with(): array
    {
        $groups = BlockCatalog::groups();
        $index = collect($groups)->search(fn (array $group): bool => $group['category'] === $this->category && $group['key'] === $this->blockName);
        $group = $index === false ? null : $groups[$index];
        $next = $index === false ? null : ($groups[$index + 1] ?? $groups[0]);

        $browse = array_map(fn (array $item): array => [
            'key' => $item['key'],
            'category' => $item['category'],
            'title' => $item['title'],
            'total' => $item['total'],
            'pro' => $item['pro'],
            'light' => $item['illustrations']['light'] ?? null,
            'dark' => $item['illustrations']['dark'] ?? $item['illustrations']['light'] ?? null,
            'url' => route('blocks.show', ['blockCategory' => $item['category'], 'blockName' => $item['key']]),
            'current' => $item['category'] === $this->category && $item['key'] === $this->blockName,
        ], $groups);

        return [
            'group' => $group,
            'next' => $next,
            'browse' => $browse,
        ];
    }
};
?>

<main x-data="{ tier: 'all' }">
    {{-- Barre du groupe : liste des blocks, fil d'Ariane, groupe suivant --}}
    <x-site.section>
        <x-site.container class="flex min-h-14 items-center justify-between gap-3 py-2.5">
            <div class="flex min-w-0 items-center gap-3.5">
                <x-ui.slideover.trigger slide-over-id="browse-blocks" variant="outline" intent="gray"
                    class="h-8.5 shrink-0 gap-2 rounded-[9px] px-3 text-[13.5px] font-medium text-title-foreground">
                    <span aria-hidden="true" class="iconify ph--sidebar-simple"></span>
                    <span class="hidden sm:inline">Browse blocks</span>
                    <span class="rounded-full bg-subtle px-1.5 text-[11.5px] text-muted-foreground">{{ count($browse) }}</span>
                </x-ui.slideover.trigger>
                <span class="hidden h-5.5 w-px bg-border sm:block"></span>
                <nav aria-label="Breadcrumb" class="flex min-w-0 items-center gap-2 text-sm">
                    <a href="{{ route('blocks.list') }}" wire:navigate class="text-muted-foreground hover:text-title-foreground">Blocks</a>
                    <span aria-hidden="true" class="iconify ph--caret-right shrink-0 text-xs text-border-strong"></span>
                    <span class="hidden text-muted-foreground capitalize sm:inline">{{ $category }}</span>
                    <span aria-hidden="true" class="iconify ph--caret-right hidden shrink-0 text-xs text-border-strong sm:inline"></span>
                    <span class="truncate font-medium text-title-foreground">{{ $group['title'] ?? $blockName }}</span>
                </nav>
            </div>
            @if ($next)
                <x-ui.button href="{{ route('blocks.show', ['blockCategory' => $next['category'], 'blockName' => $next['key']]) }}" wire:navigate
                    variant="outline" intent="gray" size="sm" class="h-8 shrink-0 gap-1.5 rounded-[10px] px-3 text-[13px] font-medium text-title-foreground">
                    <span class="hidden sm:inline">{{ $next['title'] }}</span>
                    <span class="sm:hidden">Next</span>
                    <span aria-hidden="true" class="iconify ph--caret-right text-xs"></span>
                </x-ui.button>
            @endif
        </x-site.container>
    </x-site.section>

    @if ($group && $group['total'] > 0)
        <x-site.page-header icon="ph--squares-four" :eyebrow="ucfirst($category).' · '.$group['title']" :title="$group['title']" muted="blocks">
            {{ rtrim($group['description'], '.') }}. Pick one, preview it at any width, copy the Blade or install it in one command.
            <x-slot:actions>
                <span class="text-[13.5px] text-muted-foreground">{{ $group['total'] }} blocks · {{ $group['free'] }} free · {{ $group['pro'] }} Pro</span>
                <div role="tablist" aria-label="Tier" class="flex gap-0.5 rounded-[10px] bg-subtle p-0.75">
                    @foreach (['all' => 'All', 'free' => 'Free', 'pro' => 'Pro'] as $key => $label)
                        <button type="button" role="tab" x-on:click="tier = '{{ $key }}'" x-bind:aria-selected="tier === '{{ $key }}'"
                            x-bind:class="tier === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                    @endforeach
                </div>
            </x-slot:actions>
        </x-site.page-header>

        <x-site.section>
            <div class="mx-auto flex w-full max-w-300 flex-col gap-12 pt-8 pb-16 sm:px-2 lg:px-4">
                @foreach ($group['blocks'] as $codeKey => $block)
                    <div x-show="tier === 'all' || tier === '{{ $block['tier'] ?? 'free' }}'">
                        <x-v-ui.single-block :key-ui="$blockName.'-'.$codeKey.'-'.$loop->index" :title="$block['name'] ?? ucfirst($codeKey)"
                            :is-full-screen="$block['is-full-screen'] ?? false" :preview="$block['preview'] ?? '#'"
                            :tier="$block['tier'] ?? 'free'" :code="$block" />
                    </div>
                @endforeach
            </div>
        </x-site.section>
    @else
        <x-site.section>
            <x-site.container class="py-16">
                <div class="flex flex-col items-center rounded-[20px] border border-dashed border-border-strong px-6 py-16 text-center">
                    <span class="flex size-12 items-center justify-center rounded-full bg-subtle text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--package text-lg"></span>
                    </span>
                    <h1 class="font-display mt-4 text-3xl font-semibold text-title-foreground">
                        No block yet for <span class="text-primary">{{ $group['title'] ?? $blockName }}</span>
                    </h1>
                    <p class="mt-3 max-w-lg text-muted-foreground">We're working on it — the most requested groups ship first.</p>
                    <x-ui.button href="https://github.com/unoforge/flexiwind/issues/new" class="mt-7 rounded-[10px]">Request it now</x-ui.button>
                </div>
            </x-site.container>
        </x-site.section>
    @endif

    <x-site.section>
        <x-site.container class="py-10">
            <x-site.request-banner title="Missing a block?" text="Tell us what you are building. The most requested sections ship first."
                action="Request a block" />
        </x-site.container>
    </x-site.section>

    {{-- Tous les groupes, dans un panneau latéral --}}
    <x-ui.slideover id="browse-blocks" position="left" size="3xl" :closable="false">
        <x-ui.slideover.content class="bg-background" x-data="{
            query: '',
            category: 'all',
            open: { application: true, marketing: true },
            groups: {{ Js::from($browse) }},
            inCategory(name) {
                const query = this.query.trim().toLowerCase();
                return this.groups.filter((group) => group.category === name
                    && (this.category === 'all' || this.category === name)
                    && (query === '' || group.title.toLowerCase().includes(query)));
            },
        }">
            <div class="flex flex-col gap-3.5 border-b border-border p-4.5">
                <div class="flex items-center justify-between">
                    <span class="flex flex-col gap-0.5">
                        <span class="font-display text-lg font-semibold tracking-[-0.015em] text-title-foreground">Browse blocks</span>
                        <span class="text-[12.5px] text-muted-foreground">{{ count($browse) }} groups · {{ array_sum(array_column($browse, 'total')) }} blocks</span>
                    </span>
                    <x-ui.slideover.close variant="outline" intent="gray" icon-only aria-label="Close" class="size-8 rounded-lg text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--x"></span>
                    </x-ui.slideover.close>
                </div>
                <label class="flex h-9.5 items-center gap-2 rounded-[10px] border border-border px-2.5 text-subtitle focus-within:border-primary">
                    <span aria-hidden="true" class="iconify ph--magnifying-glass"></span>
                    <input type="search" x-model="query" placeholder="Start typing…" aria-label="Search block groups"
                        class="flex-1 bg-transparent text-[13.5px] text-title-foreground outline-none">
                </label>
                <div role="tablist" aria-label="Category" class="flex gap-0.5 rounded-[9px] bg-subtle p-0.75">
                    @foreach (['all' => 'All', 'application' => 'Application', 'marketing' => 'Marketing'] as $key => $label)
                        <button type="button" role="tab" x-on:click="category = '{{ $key }}'" x-bind:aria-selected="category === '{{ $key }}'"
                            x-bind:class="category === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 flex-1 cursor-pointer rounded-[7px] text-[13px] font-medium">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
            <div class="min-h-0 flex-1 overflow-y-auto px-4.5 pt-2 pb-6">
                @foreach (['application' => 'Application', 'marketing' => 'Marketing'] as $key => $label)
                    <div x-show="inCategory('{{ $key }}').length">
                        <button type="button" x-on:click="open.{{ $key }} = !open.{{ $key }}" x-bind:aria-expanded="open.{{ $key }}"
                            class="flex h-11 w-full cursor-pointer items-center justify-between gap-2">
                            <span class="flex items-center gap-2 text-[13.5px] font-semibold text-title-foreground">
                                <span aria-hidden="true" class="iconify ph--caret-right text-xs transition-transform" x-bind:class="open.{{ $key }} && 'rotate-90'"></span>
                                {{ $label }}
                            </span>
                            <span class="rounded-md bg-surface px-2 py-px text-[11.5px] text-foreground ring-1 ring-border" x-text="inCategory('{{ $key }}').length"></span>
                        </button>
                        <div x-show="open.{{ $key }}" class="grid grid-cols-2 gap-3 pt-1 pb-4">
                            <template x-for="item in inCategory('{{ $key }}')" :key="item.key">
                                <a x-bind:href="item.url" wire:navigate
                                    x-bind:class="item.current ? 'border-primary ring-3 ring-primary/15' : 'border-border hover:border-border-strong'"
                                    class="flex flex-col gap-2 rounded-xl border bg-background p-1.5 transition-colors">
                                    <div class="relative h-32 overflow-hidden rounded-[9px] bg-surface">
                                        <img x-bind:src="item.light" x-bind:alt="item.title + ' preview'" loading="lazy" class="size-full object-cover dark:hidden">
                                        <img x-bind:src="item.dark" x-bind:alt="item.title + ' preview'" loading="lazy" class="hidden size-full object-cover dark:block">
                                        <span class="absolute top-1.5 right-1.5 rounded-[5px] bg-background/85 px-1.75 py-px text-[11px] text-foreground ring-1 ring-border" x-text="item.total"></span>
                                    </div>
                                    <div class="flex items-center justify-between gap-1.5 px-1 pb-1">
                                        <span class="truncate text-[13px] font-semibold text-title-foreground" x-text="item.title"></span>
                                        <span x-show="item.pro" class="rounded-full bg-primary/10 px-1.5 text-[10.5px] font-semibold text-primary">Pro</span>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                @endforeach
                <p x-show="!inCategory('application').length && !inCategory('marketing').length" x-cloak
                    class="px-3 py-10 text-center text-[13.5px] text-muted-foreground">No group matches “<span x-text="query"></span>”.</p>
            </div>
        </x-ui.slideover.content>
    </x-ui.slideover>
</main>
