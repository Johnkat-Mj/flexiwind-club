@props(['blockCount'])

{{--
    Vitrine de la home : trois onglets (Components, Blocks, Templates) qui
    tournent seuls jusqu'à la première interaction. Tout ce qui s'affiche
    dans l'onglet Components est un vrai composant Flexiwind : la couleur
    choisie ne fait que redéfinir --primary sur le panneau.
--}}
@php
    $tabs = [
        ['id' => 'components', 'icon' => 'ph--cube', 'title' => 'Components', 'text' => 'Primitives you compose and own'],
        ['id' => 'blocks', 'icon' => 'ph--squares-four', 'title' => 'Blocks', 'text' => $blockCount.' sections, ready to drop in'],
        ['id' => 'templates', 'icon' => 'ph--layout', 'title' => 'Templates', 'text' => 'Whole apps to start from'],
    ];

    // Cinq blocks réels, gratuits et Pro, pris dans config/blocks.php.
    $picks = [
        ['application', 'login-form', 'login01', 'Login'],
        ['application', 'login-form', 'pro-login03', 'Login'],
        ['application', 'dash-card-kpi', 'kpi01', 'Dash KPI'],
        ['application', 'dash-card-kpi', 'kpi-03', 'Dash KPI'],
        ['application', 'app-table', 'table05', 'Table'],
    ];
    $showcaseBlocks = [];
    foreach ($picks as [$category, $group, $key, $label]) {
        $block = config("blocks.{$category}.{$group}.blocks.{$key}");
        if ($block) {
            $showcaseBlocks[] = [
                'id' => $block['name'],
                'group' => $label,
                'category' => $category,
                'groupKey' => $group,
                'pro' => ($block['tier'] ?? 'free') === 'pro',
                'preview' => $block['preview'],
            ];
        }
    }
    $canSeePro = Flexiwind\Docs\Tier::current()->grants(Flexiwind\Docs\Tier::Pro);
@endphp

<x-site.section x-data="homeShowcase({{ Js::from($showcaseBlocks) }})" class="pb-12 lg:pb-16">
    <div role="tablist" aria-label="What Flexiwind gives you"
        class="mx-auto grid w-full max-w-300 border-x border-b border-border sm:grid-cols-3 sm:divide-x sm:divide-border">
        @foreach ($tabs as $tab)
            <button type="button" role="tab" x-on:click="pick('{{ $tab['id'] }}')"
                x-bind:aria-selected="tab === '{{ $tab['id'] }}'"
                x-bind:class="tab === '{{ $tab['id'] }}' ? 'bg-background' : 'bg-surface'"
                class="relative flex h-20 cursor-pointer items-center gap-3.5 px-5 text-left transition-colors lg:h-24 lg:px-7">
                <span aria-hidden="true" x-show="tab === '{{ $tab['id'] }}'" class="absolute -top-px left-0 h-0.5 bg-primary"
                    x-bind:class="picked ? 'w-full' : 'animate-[site-progress_8s_linear_both]'"></span>
                <span x-bind:class="tab === '{{ $tab['id'] }}'
                        ? 'bg-primary text-primary-foreground border-transparent shadow-[0_6px_14px_-6px_var(--color-primary)]'
                        : 'bg-background text-muted-foreground border-border'"
                    class="flex size-10 shrink-0 items-center justify-center rounded-[11px] border transition-all">
                    <span aria-hidden="true" class="iconify {{ $tab['icon'] }} text-lg"></span>
                </span>
                <span class="flex flex-col gap-0.5">
                    <span x-bind:class="tab === '{{ $tab['id'] }}' ? 'text-title-foreground' : 'text-foreground'"
                        class="text-[15px]/5 font-semibold">{{ $tab['title'] }}</span>
                    <span class="text-sm/5 text-muted-foreground">{{ $tab['text'] }}</span>
                </span>
            </button>
        @endforeach
    </div>

    <x-site.container class="pt-6">
        <div role="tabpanel"
            class="flex h-170 flex-col overflow-hidden rounded-[18px] border border-border bg-background shadow-[0_1px_2px_rgba(9,9,11,.04),0_40px_80px_-40px_rgba(9,9,11,.28)]">

            {{-- Barre de fenêtre --}}
            <div class="flex h-11 shrink-0 items-center justify-between gap-3 border-b border-border px-3.5">
                <div class="hidden w-50 gap-1.5 md:flex">
                    <span class="size-2.5 rounded-full bg-border"></span>
                    <span class="size-2.5 rounded-full bg-border"></span>
                    <span class="size-2.5 rounded-full bg-border"></span>
                </div>
                <div class="flex h-7 w-full max-w-75 items-center justify-center gap-1.5 rounded-lg border border-border/60 bg-surface font-mono text-xs text-muted-foreground">
                    <span aria-hidden="true" class="iconify ph--lock-simple text-xs"></span>
                    <span class="truncate" x-text="url">acme.test/components</span>
                </div>
                <div class="hidden w-50 justify-end md:flex">
                    <div x-show="tab === 'components'" role="radiogroup" aria-label="Primary color" class="flex items-center gap-1.75">
                        <span class="mr-0.5 font-mono text-xs text-muted-foreground">--primary</span>
                        <template x-for="swatch in swatches" :key="swatch.hex">
                            <button type="button" role="radio" x-bind:aria-checked="accent === swatch.hex"
                                x-bind:aria-label="swatch.name" x-on:click="setAccent(swatch)"
                                x-bind:style="`background:${swatch.hex};box-shadow:${accent === swatch.hex ? '0 0 0 2px var(--color-background),0 0 0 3.5px ' + swatch.hex : 'none'}`"
                                class="size-4 cursor-pointer rounded-full"></button>
                        </template>
                    </div>
                    <div x-show="tab === 'templates'" x-cloak class="flex items-center gap-2">
                        <div role="tablist" aria-label="Templates" class="flex gap-0.5 rounded-lg bg-subtle p-0.5">
                            <template x-for="[key, label] in [['crm', 'CRM'], ['starter', 'Starter']]" :key="key">
                                <button type="button" role="tab" x-bind:aria-selected="template === key"
                                    x-on:click="template = key; stop()" x-text="label"
                                    x-bind:class="template === key ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                    class="h-6 cursor-pointer rounded-md px-2.5 text-xs font-medium"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative min-h-0 flex-1">
                {{-- ============ Components ============ --}}
                <div x-show="tab === 'components'" x-bind:style="`--primary:${accent}`"
                    class="bg-dots absolute inset-0 flex gap-5 overflow-auto bg-surface p-4 sm:p-6">
                    <div class="hidden w-72.5 shrink-0 flex-col gap-4 lg:flex">
                        <x-ui.card class="flex flex-col gap-3.5 rounded-[14px] p-4.5 shadow-xs">
                            <div class="flex items-center gap-3">
                                <span class="flex size-11 items-center justify-center rounded-full bg-primary/12 text-[15px] font-semibold text-primary">AD</span>
                                <div class="flex flex-col">
                                    <span class="text-[15px] font-semibold text-title-foreground">Amara Diallo</span>
                                    <span class="text-[13px] text-muted-foreground">amara@acme.test</span>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-[13px] text-muted-foreground">
                                <span aria-hidden="true" class="iconify ph--buildings"></span>Acme Inc. · Product design
                            </span>
                            <div class="flex gap-2">
                                <x-ui.button size="sm" class="h-8.5 flex-1 justify-center rounded-[9px] px-2 text-[13px]"
                                    x-on:click="inspect('&lt;x-ui.button intent=&quot;primary&quot;>')">Manage profile</x-ui.button>
                                <x-ui.button size="sm" variant="outline" intent="gray"
                                    class="h-8.5 flex-1 justify-center rounded-[9px] px-2 text-[13px] text-title-foreground"
                                    x-on:click="inspect('&lt;x-ui.button variant=&quot;outline&quot; intent=&quot;gray&quot;>')">View details</x-ui.button>
                            </div>
                        </x-ui.card>

                        <x-ui.card x-on:click="inspect('&lt;x-ui.progress value=&quot;30&quot; />')"
                            class="flex cursor-pointer flex-col gap-2.5 rounded-[14px] px-4.5 py-4 shadow-xs">
                            <span class="text-sm font-semibold text-title-foreground">Plan UI components v1</span>
                            <span class="text-[13px]/[1.4] text-muted-foreground">Pick the primitives for the first release.</span>
                            <x-ui.progress value="30" max="100" size="sm" class="w-full text-primary" />
                            <span class="flex items-center justify-between text-xs text-muted-foreground">
                                <span class="flex -space-x-1.5">
                                    <span class="flex size-6 items-center justify-center rounded-full bg-primary/12 text-[10px] font-semibold text-primary ring-2 ring-card">AD</span>
                                    <span class="flex size-6 items-center justify-center rounded-full bg-subtle text-[10px] font-semibold text-title-foreground ring-2 ring-card">KS</span>
                                    <span class="flex size-6 items-center justify-center rounded-full bg-subtle text-[10px] font-semibold text-title-foreground ring-2 ring-card">LM</span>
                                </span>
                                3 of 10 done
                            </span>
                        </x-ui.card>

                        <x-ui.card class="flex flex-col rounded-[14px] px-4.5 py-1.5 shadow-xs">
                            <label class="flex h-12 items-center justify-between border-b border-border/60 text-sm text-title-foreground">
                                Email alerts
                                <x-ui.switch size="sm" x-model="emailAlerts" x-on:change="inspect('&lt;x-ui.switch />')" />
                            </label>
                            <label class="flex h-12 items-center justify-between text-sm text-title-foreground">
                                Weekly digest
                                <x-ui.switch size="sm" x-model="weeklyDigest" x-on:change="inspect('&lt;x-ui.switch />')" />
                            </label>
                        </x-ui.card>
                    </div>

                    <x-ui.card class="flex min-w-0 flex-1 flex-col self-start overflow-hidden rounded-[14px] p-0 shadow-xs">
                        <div class="flex h-15 shrink-0 items-center gap-2 border-b border-border px-3.5">
                            <label class="flex h-8.5 flex-1 items-center gap-2 rounded-[9px] border border-border px-2.5 text-subtitle">
                                <span aria-hidden="true" class="iconify ph--magnifying-glass text-sm"></span>
                                <input type="text" placeholder="Search members" aria-label="Search members"
                                    x-on:focus="inspect('&lt;x-ui.input placeholder=&quot;Search members&quot; />')"
                                    class="w-full bg-transparent text-[13px] text-title-foreground outline-none">
                            </label>
                            <x-ui.button size="sm" variant="outline" intent="gray"
                                class="hidden h-8.5 gap-1.5 rounded-[9px] px-3 text-[13px] text-title-foreground sm:flex"
                                x-on:click="inspect('&lt;x-ui.button variant=&quot;outline&quot; intent=&quot;gray&quot;>')">
                                <span aria-hidden="true" class="iconify ph--download-simple"></span>Export
                            </x-ui.button>
                            <x-ui.button size="sm" intent="neutral" class="h-8.5 gap-1.5 rounded-[9px] px-3 text-[13px]"
                                x-on:click="inspect('&lt;x-ui.button intent=&quot;neutral&quot;>')">
                                <span aria-hidden="true" class="iconify ph--plus"></span>Invite
                            </x-ui.button>
                        </div>
                        <div class="flex h-9.5 shrink-0 items-center gap-3 border-b border-border bg-surface px-3.5 text-xs font-medium text-muted-foreground">
                            <span class="w-4"></span>
                            <span class="flex-1">Member</span>
                            <span class="hidden w-33 sm:block">Tokens used</span>
                            <span class="w-19.5">Role</span>
                        </div>
                        <template x-for="member in members" :key="member.email">
                            <label x-bind:class="member.checked ? 'bg-primary/7' : 'bg-card'"
                                x-on:click="inspect('&lt;x-ui.table.row>')"
                                class="flex h-13 cursor-pointer items-center gap-3 border-b border-border/60 px-3.5 transition-colors">
                                <x-ui.checkbox x-model="member.checked" class="mt-0" />
                                <span class="flex min-w-0 flex-1 items-center gap-2.5">
                                    <span x-text="member.init"
                                        x-bind:class="member.init === 'AD' ? 'bg-primary/12 text-primary' : 'bg-subtle text-title-foreground'"
                                        class="flex size-8 shrink-0 items-center justify-center rounded-full text-[11.5px] font-semibold"></span>
                                    <span class="flex min-w-0 flex-col">
                                        <span class="text-[13.5px] font-medium text-title-foreground" x-text="member.name"></span>
                                        <span class="truncate text-xs text-muted-foreground" x-text="member.email"></span>
                                    </span>
                                </span>
                                <span class="hidden w-33 items-center gap-2 sm:flex">
                                    <span class="h-1.25 flex-1 overflow-hidden rounded-full bg-subtle">
                                        <span class="block h-full rounded-full"
                                            x-bind:class="member.usage > 60 ? 'bg-orange-600' : 'bg-primary'"
                                            x-bind:style="`width:${member.usage}%`"></span>
                                    </span>
                                    <span class="w-8.5 font-mono text-[11.5px] text-muted-foreground" x-text="member.usage + '%'"></span>
                                </span>
                                <span class="w-19.5">
                                    <span x-text="member.role"
                                        x-bind:class="{
                                            'bg-gray-900 text-white dark:bg-white dark:text-gray-950': member.role === 'Admin',
                                            'bg-primary/12 text-primary': member.role === 'Editor',
                                            'bg-subtle text-foreground': member.role === 'Viewer',
                                        }"
                                        class="rounded-md px-2 py-0.5 text-[11.5px] font-medium"></span>
                                </span>
                            </label>
                        </template>
                        <div class="flex h-12.5 shrink-0 items-center justify-between px-3.5 text-[12.5px] text-muted-foreground">
                            <span x-text="selectedLabel"></span>
                            <span class="flex items-center gap-1.5">Page 1 of 3
                                <span class="flex size-7 items-center justify-center rounded-md border border-border text-title-foreground">
                                    <span aria-hidden="true" class="iconify ph--caret-right text-xs"></span>
                                </span>
                            </span>
                        </div>
                    </x-ui.card>

                    <div class="hidden w-70 shrink-0 flex-col gap-4 xl:flex">
                        <div class="flex gap-2">
                            <x-ui.button class="h-9.5 flex-1 justify-center gap-1.5 rounded-[10px] px-3"
                                x-on:click="inspect('&lt;x-ui.button intent=&quot;primary&quot;>')">
                                <span aria-hidden="true" class="iconify ph--plus"></span>Create user
                            </x-ui.button>
                            <x-ui.button variant="outline" intent="gray" icon-only aria-label="Filter"
                                class="size-9.5 rounded-[10px] text-title-foreground"
                                x-on:click="inspect('&lt;x-ui.button variant=&quot;outline&quot; intent=&quot;gray&quot; iconOnly>')">
                                <span aria-hidden="true" class="iconify ph--funnel-simple"></span>
                            </x-ui.button>
                        </div>
                        <div role="radiogroup" aria-label="Period" class="flex gap-0.5 rounded-[10px] bg-subtle p-0.75">
                            <template x-for="label in ['Day', 'Week', 'Month']" :key="label">
                                <button type="button" role="radio" x-bind:aria-checked="period === label" x-text="label"
                                    x-on:click="period = label; inspect(`&lt;x-ui.tabs.trigger id=&quot;${label.toLowerCase()}&quot;>`)"
                                    x-bind:class="period === label ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                    class="h-7.5 flex-1 cursor-pointer rounded-[7px] text-[13px] font-medium transition-all"></button>
                            </template>
                        </div>
                        <x-ui.card class="flex flex-col gap-3 rounded-[14px] px-4 py-3.5 shadow-xs">
                            <div class="flex justify-between text-[13px]">
                                <span class="font-medium text-title-foreground">Opacity</span>
                                <span class="font-mono text-muted-foreground" x-text="opacity + '%'"></span>
                            </div>
                            <input type="range" min="0" max="100" step="25" x-model.number="opacity"
                                x-on:input="inspect(`&lt;x-ui.range value=&quot;${opacity}&quot; />`)" aria-label="Opacity"
                                class="w-full cursor-pointer accent-(--primary)">
                        </x-ui.card>
                        <x-ui.card class="flex gap-3 rounded-[14px] p-4 shadow-xs">
                            <span class="flex size-9.5 shrink-0 items-center justify-center rounded-[10px] border border-border text-title-foreground">
                                <span aria-hidden="true" class="iconify ph--github-logo text-lg"></span>
                            </span>
                            <div class="flex flex-1 flex-col items-start gap-0.75">
                                <span class="text-sm font-semibold text-title-foreground">GitHub</span>
                                <span class="text-[12.5px]/[1.35] text-muted-foreground">Link pull requests and commits to tasks.</span>
                                <x-ui.button size="xs"
                                    x-on:click="githubLinked = !githubLinked; inspect('&lt;x-ui.button size=&quot;xs&quot;>')"
                                    x-bind:class="githubLinked ? 'bg-success/12! text-success!' : ''"
                                    class="mt-1.5 h-7 gap-1 rounded-lg px-2.5 text-xs">
                                    <span aria-hidden="true" class="iconify ph--check" x-show="githubLinked" x-cloak></span>
                                    <span x-text="githubLinked ? 'Connected' : 'Connect'">Connect</span>
                                </x-ui.button>
                            </div>
                        </x-ui.card>
                        <x-ui.card
                            class="flex flex-1 flex-col items-center justify-center gap-2 rounded-[14px] border border-dashed border-border-strong p-4 text-center shadow-none ring-0">
                            <span class="flex size-9.5 items-center justify-center rounded-full bg-subtle text-title-foreground">
                                <span aria-hidden="true" class="iconify ph--calendar-blank"></span>
                            </span>
                            <span class="text-sm font-semibold text-title-foreground">No schedules yet</span>
                            <x-ui.button size="xs" variant="outline" intent="gray"
                                class="h-8 rounded-[9px] px-3 text-[13px] text-title-foreground"
                                x-on:click="inspect('&lt;x-ui.button variant=&quot;outline&quot; intent=&quot;gray&quot;>')">Create schedule</x-ui.button>
                        </x-ui.card>
                    </div>

                    <div class="pointer-events-none absolute inset-x-0 bottom-4.5 flex justify-center px-4">
                        <div class="pointer-events-auto flex h-10.5 max-w-full items-center gap-3 rounded-full border border-white/8 bg-code pr-1.25 pl-3.5 font-mono text-[13px] text-code-foreground shadow-[0_14px_30px_-10px_rgba(9,9,11,.45)]">
                            <span aria-hidden="true" class="iconify ph--code text-indigo-300"></span>
                            <span class="truncate" x-bind:class="inspected ? 'text-indigo-300' : 'text-code-muted'"
                                x-text="inspected ?? 'Click any element to see its component'"></span>
                            <span class="hidden h-8 items-center rounded-full bg-white/9 px-3 font-sans text-[12.5px] font-medium whitespace-nowrap text-white sm:flex"
                                x-text="inspected ? 'That is all the markup' : 'Live, not a screenshot'"></span>
                        </div>
                    </div>
                </div>

                {{-- ============ Blocks ============ --}}
                <div x-show="tab === 'blocks'" x-cloak class="absolute inset-0 flex flex-col">
                    <div class="flex min-h-14 shrink-0 flex-wrap items-center justify-between gap-3 border-b border-border px-3.5 py-2 sm:pl-4.5">
                        <div class="flex items-center gap-3">
                            <span class="hidden items-center gap-1.5 text-[13.5px] text-muted-foreground md:flex">
                                Application
                                <span aria-hidden="true" class="iconify ph--caret-right text-xs text-border-strong"></span>
                                <span x-text="block.group"></span>
                                <span aria-hidden="true" class="iconify ph--caret-right text-xs text-border-strong"></span>
                            </span>
                            <span class="font-mono text-[13px] font-medium text-title-foreground" x-text="block.id"></span>
                            <span x-text="block.pro ? 'Pro' : 'Free'"
                                x-bind:class="block.pro ? 'bg-primary/10 text-primary' : 'bg-subtle text-foreground'"
                                class="rounded-full px-2 py-0.5 text-xs font-semibold"></span>
                            <div class="ml-1 flex items-center gap-0.5">
                                <x-ui.button variant="outline" intent="gray" size="xs" icon-only aria-label="Previous block"
                                    x-on:click="stepBlock(-1)" class="size-7.5 rounded-lg text-title-foreground">
                                    <span aria-hidden="true" class="iconify ph--caret-left"></span>
                                </x-ui.button>
                                <span class="min-w-11 text-center font-mono text-xs text-muted-foreground"
                                    x-text="(blockIndex + 1) + ' / ' + blocks.length"></span>
                                <x-ui.button variant="outline" intent="gray" size="xs" icon-only aria-label="Next block"
                                    x-on:click="stepBlock(1)" class="size-7.5 rounded-lg text-title-foreground">
                                    <span aria-hidden="true" class="iconify ph--caret-right"></span>
                                </x-ui.button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="flex gap-0.5 rounded-[9px] bg-subtle p-0.75">
                                <template x-for="view in ['preview', 'code']" :key="view">
                                    <button type="button" x-on:click="blockView = view; stop()"
                                        x-text="view === 'preview' ? 'Preview' : 'Code'"
                                        x-bind:class="blockView === view ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                        class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium"></button>
                                </template>
                            </div>
                            <div class="hidden gap-0.5 md:flex">
                                <template x-for="[size, icon] in [['desktop', 'ph--laptop'], ['tablet', 'ph--device-tablet-camera'], ['mobile', 'ph--device-mobile-camera']]" :key="size">
                                    <button type="button" x-on:click="device = size; stop()" x-bind:aria-label="size + ' width'"
                                        x-bind:class="device === size ? 'border-border bg-background text-title-foreground' : 'border-transparent text-muted-foreground'"
                                        class="flex size-7.5 cursor-pointer items-center justify-center rounded-lg border">
                                        <span aria-hidden="true" class="iconify" x-bind:class="icon"></span>
                                    </button>
                                </template>
                            </div>
                            <button type="button" x-data="copyText()"
                                x-on:click="copy('php artisan flexi:add ' + (block.pro ? '@fx/' : '') + block.id)"
                                class="hidden h-8 cursor-pointer items-center gap-2 rounded-[9px] bg-code pr-1 pl-3 font-mono text-[12.5px] text-code-foreground sm:flex">
                                <span><span class="text-code-muted">flexi:add </span><span class="text-indigo-300" x-show="block.pro">@fx/</span><span x-text="block.id"></span></span>
                                <span class="flex size-6.5 items-center justify-center text-code-muted">
                                    <span aria-hidden="true" class="iconify ph--copy text-sm" x-show="!copied"></span>
                                    <span aria-hidden="true" class="iconify ph--check text-sm text-success" x-show="copied" x-cloak></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="relative min-h-0 flex-1">
                        <div x-show="blockView === 'preview'" class="bg-dots absolute inset-0 flex justify-center bg-surface p-3 sm:p-5.5">
                            <div x-bind:style="`width:${frameWidth}`"
                                class="h-full max-w-full overflow-hidden rounded-xl border border-border bg-background shadow-[0_20px_40px_-24px_rgba(9,9,11,.3)] transition-[width] duration-300">
                                <template x-if="tab === 'blocks'">
                                    <iframe x-bind:src="block.preview" x-bind:title="block.id + ' preview'" loading="lazy"
                                        x-preview-frame class="size-full"></iframe>
                                </template>
                            </div>
                        </div>
                        <div x-show="blockView === 'code'" x-cloak class="absolute inset-0 overflow-auto bg-code">
                            @foreach ($showcaseBlocks as $index => $item)
                                <div x-show="blockIndex === {{ $index }}" class="h-full">
                                    @if ($item['pro'] && ! $canSeePro)
                                        <div class="flex h-full flex-col items-center justify-center gap-2.5 px-6 text-center">
                                            <span aria-hidden="true" class="iconify ph--lock-simple text-xl text-code-muted"></span>
                                            <span class="text-[15px] font-medium text-white">Source reserved for Pro</span>
                                            <span class="max-w-90 text-[13px] text-code-muted">The preview stays open to everyone. Unlock the code to install it with @fx/.</span>
                                            <a href="{{ route('pricing') }}" wire:navigate
                                                class="mt-1 flex h-8 items-center gap-1.5 rounded-lg bg-white px-3.5 text-sm font-medium text-gray-950">
                                                Unlock with Pro <span aria-hidden="true" class="iconify ph--arrow-right text-xs"></span>
                                            </a>
                                        </div>
                                    @else
                                        <x-code-panel.block :name="$item['id']" :tier="$item['pro'] ? 'pro' : 'free'" flush />
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ============ Templates ============ --}}
                <div x-show="tab === 'templates'" x-cloak class="absolute inset-0"
                    x-on:demo-page="templatePage[template] = $event.detail.page; stop()">
                    <div x-show="template === 'crm'" class="size-full">
                        <x-demo.crm />
                    </div>
                    <div x-show="template === 'starter'" x-cloak class="size-full">
                        <x-demo.starter />
                    </div>
                </div>
            </div>
        </div>
    </x-site.container>
     <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-1.5 z-50 hidden lg:block">
        <div class="relative mx-auto h-2.75 w-full max-w-300">
            <x-site.cross class="-left-1.25" />
            <x-site.cross class="-right-1.25" />
        </div>
    </div>
</x-site.section>
