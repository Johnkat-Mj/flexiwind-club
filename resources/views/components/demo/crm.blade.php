@props(['branded' => true])

{{--
    Démo du template CRM : une vraie petite application Alpine, construite
    avec les composants Flexiwind. Le template repeint --primary en bleu
    pour montrer qu'une app garde son identité avec les mêmes composants.
--}}
@php
    $nav = [
        ['dashboard', 'ph--squares-four', 'Dashboard'],
        ['inbox', 'ph--tray', 'Inbox'],
        ['leads', 'ph--user-plus', 'Leads'],
        ['contacts', 'ph--users', 'Contacts'],
        ['deals', 'ph--briefcase', 'Deals'],
        ['companies', 'ph--buildings', 'Companies'],
        ['tasks', 'ph--check-square', 'Tasks'],
    ];
    $statusClasses = [
        'New' => 'bg-sky-600/12 text-sky-700 dark:text-sky-300',
        'Contacted' => 'bg-amber-500/14 text-amber-700 dark:text-amber-300',
        'Qualified' => 'bg-emerald-600/13 text-emerald-700 dark:text-emerald-300',
        'Lost' => 'bg-gray-500/13 text-gray-600 dark:text-gray-400',
    ];
@endphp

<div x-data="crmDemo" x-on:demo-go.window="go($event.detail)"
    @class([
        'flex size-full bg-background text-foreground',
        '[--primary:var(--color-sky-700)] dark:[--primary:var(--color-sky-500)]' => $branded,
    ])>
    <aside class="hidden w-54 shrink-0 flex-col gap-0.5 border-r border-border bg-surface px-3 py-3.5 md:flex">
        <span class="mb-2.5 flex h-8 items-center gap-2 px-1.5 text-sm font-semibold text-title-foreground">
            <span class="flex size-6 items-center justify-center rounded-md bg-primary text-white">
                <span aria-hidden="true" class="iconify ph--chart-bar text-sm"></span>
            </span>
            Acme CRM
        </span>
        <label class="mb-2 flex h-8 items-center gap-2 rounded-lg border border-border bg-background px-2.5 text-subtitle">
            <span aria-hidden="true" class="iconify ph--magnifying-glass text-xs"></span>
            <input type="text" placeholder="Start typing…" aria-label="Search" class="w-full bg-transparent text-xs text-title-foreground outline-none">
        </label>
        @foreach ($nav as [$page, $icon, $label])
            <button type="button" x-on:click="go('{{ $page }}')"
                x-bind:class="page === '{{ $page }}' ? 'bg-background text-title-foreground font-medium shadow-xs ring-1 ring-border' : 'text-foreground hover:bg-subtle'"
                class="flex h-8.5 w-full cursor-pointer items-center gap-2.5 rounded-lg px-2.5 text-[13px]">
                <span aria-hidden="true" class="iconify {{ $icon }} text-sm"></span>
                <span class="flex-1 text-left">{{ $label }}</span>
                @if ($page === 'inbox')
                    <span class="rounded-full bg-primary/12 px-1.5 text-[10.5px] font-semibold text-primary">4</span>
                @elseif ($page === 'tasks')
                    <span class="rounded-full bg-subtle px-1.5 text-[10.5px] font-semibold text-muted-foreground" x-text="openTasks"></span>
                @endif
            </button>
        @endforeach
        <div class="mt-auto flex flex-col gap-2">
            <button type="button" x-on:click="go('settings')"
                x-bind:class="page === 'settings' ? 'bg-background text-title-foreground font-medium shadow-xs ring-1 ring-border' : 'text-foreground hover:bg-subtle'"
                class="flex h-8.5 w-full cursor-pointer items-center gap-2.5 rounded-lg px-2.5 text-[13px]">
                <span aria-hidden="true" class="iconify ph--gear-six text-sm"></span>Settings
            </button>
            <div class="flex items-center gap-2 rounded-lg border border-border bg-background p-2">
                <span class="flex size-7 items-center justify-center rounded-full bg-primary/12 text-[10.5px] font-semibold text-primary">AD</span>
                <span class="flex min-w-0 flex-1 flex-col">
                    <span class="truncate text-xs font-medium text-title-foreground">Amara Diallo</span>
                    <span class="text-[11px] text-muted-foreground">Sales lead</span>
                </span>
                <span aria-hidden="true" class="iconify ph--caret-up-down text-xs text-muted-foreground"></span>
            </div>
        </div>
    </aside>

    <main class="flex min-w-0 flex-1 flex-col">
        <div class="flex h-12 shrink-0 items-center justify-between border-b border-border px-4">
            <span class="flex items-center gap-1.5 text-[13px] text-muted-foreground">
                <span aria-hidden="true" class="iconify ph--house text-sm"></span>Home
                <span aria-hidden="true" class="iconify ph--caret-right text-xs text-border-strong"></span>
                <span class="font-medium text-title-foreground" x-text="titles[page]"></span>
            </span>
            <x-ui.button size="xs" icon-only aria-label="Create" class="size-7 rounded-lg">
                <span aria-hidden="true" class="iconify ph--plus"></span>
            </x-ui.button>
        </div>

        <div class="min-h-0 flex-1 overflow-auto p-4 sm:p-5">
            {{-- Dashboard --}}
            <div x-show="page === 'dashboard'" class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-title-foreground">Dashboard</span>
                    <div class="flex gap-2">
                        <x-ui.button size="xs" variant="outline" intent="gray" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs text-title-foreground">
                            <span aria-hidden="true" class="iconify ph--funnel-simple"></span>Filter
                        </x-ui.button>
                        <x-ui.button size="xs" variant="outline" intent="gray" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs text-title-foreground">
                            <span aria-hidden="true" class="iconify ph--download-simple"></span>Export
                        </x-ui.button>
                    </div>
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    @foreach ([['New leads', '125', true, '15%', 'vs last week'], ['Deals closed', '30', false, '5%', 'vs last month'], ['Revenue generated', '$12,500', true, '8%', 'this quarter']] as [$label, $value, $up, $delta, $period])
                        <x-ui.card class="flex flex-col gap-1.5 rounded-xl p-4 shadow-none">
                            <span class="text-xs text-muted-foreground">{{ $label }}</span>
                            <span class="font-display text-2xl font-semibold tracking-tight text-title-foreground">{{ $value }}</span>
                            <span class="flex items-center gap-1.5 text-xs text-muted-foreground">
                                <span @class(['flex items-center gap-0.5 font-medium', 'text-success' => $up, 'text-destructive' => ! $up])>
                                    <span aria-hidden="true" class="iconify {{ $up ? 'ph--trend-up' : 'ph--trend-down' }}"></span>{{ $delta }}
                                </span>{{ $period }}
                            </span>
                        </x-ui.card>
                    @endforeach
                </div>
                <x-ui.card class="flex flex-col gap-4 rounded-xl p-4 shadow-none">
                    <div class="flex items-start justify-between gap-3">
                        <span class="flex flex-col">
                            <span class="text-sm font-semibold text-title-foreground">Deal analytics</span>
                            <span class="text-xs text-muted-foreground">Closed vs lost deals by month</span>
                        </span>
                        <div class="flex gap-0.5 rounded-lg bg-subtle p-0.5">
                            <template x-for="months in [6, 12]" :key="months">
                                <button type="button" x-on:click="range = months" x-text="months + ' months'"
                                    x-bind:class="range === months ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                    class="h-6.5 cursor-pointer rounded-md px-2.5 text-xs font-medium"></button>
                            </template>
                        </div>
                    </div>
                    <div class="flex h-40 items-end gap-1">
                        <template x-for="bar in bars" :key="bar.month">
                            <div class="flex h-full flex-1 flex-col items-center gap-1.5">
                                <div class="flex w-full flex-1 items-end justify-center gap-0.5">
                                    <span class="w-[42%] max-w-4 rounded-t-[3px] bg-emerald-500 transition-[height] duration-300" x-bind:style="`height:${bar.closed}%`"></span>
                                    <span class="w-[42%] max-w-4 rounded-t-[3px] bg-red-500 transition-[height] duration-300" x-bind:style="`height:${bar.lost}%`"></span>
                                </div>
                                <span class="text-[10.5px] text-muted-foreground" x-text="bar.month"></span>
                            </div>
                        </template>
                    </div>
                    <div class="flex gap-4 text-xs text-muted-foreground">
                        <span class="flex items-center gap-1.5"><span class="size-2 rounded-xs bg-emerald-500"></span>Closed</span>
                        <span class="flex items-center gap-1.5"><span class="size-2 rounded-xs bg-red-500"></span>Lost</span>
                    </div>
                </x-ui.card>
            </div>

            {{-- Leads --}}
            <div x-show="page === 'leads'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-title-foreground">Leads</span>
                    <x-ui.button size="xs" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs">
                        <span aria-hidden="true" class="iconify ph--plus"></span>New lead
                    </x-ui.button>
                </div>
                <x-ui.card class="overflow-hidden rounded-xl p-0 shadow-none">
                    <div class="flex h-9.5 items-center gap-3 border-b border-border bg-surface px-3.5 text-[11.5px] font-medium text-muted-foreground">
                        <span class="w-4"></span>
                        <span class="flex-1">Name</span>
                        <span class="hidden w-28 sm:block">Company</span>
                        <span class="hidden w-20 lg:block">Source</span>
                        <span class="w-22">Status</span>
                        <span class="w-16 text-right">Value</span>
                    </div>
                    <template x-for="lead in leads" :key="lead.name">
                        <label x-bind:class="lead.checked ? 'bg-primary/7' : ''"
                            class="flex h-11 cursor-pointer items-center gap-3 border-b border-border/60 px-3.5 text-[12.5px] last:border-0">
                            <x-ui.checkbox x-model="lead.checked" class="mt-0" />
                            <span class="flex-1 truncate font-medium text-title-foreground" x-text="lead.name"></span>
                            <span class="hidden w-28 truncate text-foreground sm:block" x-text="lead.company"></span>
                            <span class="hidden w-20 text-muted-foreground lg:block" x-text="lead.source"></span>
                            <span class="w-22">
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-medium" x-text="lead.status"
                                    x-bind:class="{{ Js::from($statusClasses) }}[lead.status]"></span>
                            </span>
                            <span class="w-16 text-right font-mono text-title-foreground" x-text="lead.value"></span>
                        </label>
                    </template>
                </x-ui.card>
            </div>

            {{-- Deals --}}
            <div x-show="page === 'deals'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <span class="flex flex-col">
                        <span class="text-lg font-semibold text-title-foreground">Deals</span>
                        <span class="text-xs text-muted-foreground">Move a deal forward with the arrow.</span>
                    </span>
                    <span class="font-mono text-xs text-muted-foreground">Won: <span class="font-semibold text-success" x-text="wonTotal"></span></span>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <template x-for="(stage, index) in stageNames" :key="stage">
                        <div class="flex flex-col gap-2 rounded-xl bg-surface p-2.5 ring-1 ring-border">
                            <div class="flex items-center justify-between px-1">
                                <span class="flex items-center gap-2 text-xs font-semibold text-title-foreground">
                                    <span class="size-2 rounded-full" x-bind:class="stageColors[index]"></span>
                                    <span x-text="stage"></span>
                                </span>
                                <span class="text-xs text-muted-foreground" x-text="dealsIn(index).length"></span>
                            </div>
                            <template x-for="deal in dealsIn(index)" :key="deal.id">
                                <div class="flex animate-pop flex-col gap-1 rounded-lg border border-border bg-background p-2.5 shadow-xs">
                                    <span class="text-[12.5px] font-medium text-title-foreground" x-text="deal.title"></span>
                                    <span class="text-[11.5px] text-muted-foreground" x-text="deal.company"></span>
                                    <div class="mt-1 flex items-center justify-between">
                                        <span class="font-mono text-xs text-title-foreground" x-text="money(deal.value)"></span>
                                        <button type="button" x-show="index < 3" x-on:click="deal.stage++" aria-label="Move to next stage"
                                            class="flex size-6 cursor-pointer items-center justify-center rounded-md border border-border text-title-foreground hover:bg-subtle">
                                            <span aria-hidden="true" class="iconify ph--arrow-right text-xs"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Contacts --}}
            <div x-show="page === 'contacts'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-title-foreground">Contacts</span>
                    <x-ui.button size="xs" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs">
                        <span aria-hidden="true" class="iconify ph--plus"></span>Add contact
                    </x-ui.button>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    <template x-for="[initials, name, role, company] in contacts" :key="name">
                        <x-ui.card class="flex flex-col gap-3 rounded-xl p-3.5 shadow-none">
                            <div class="flex items-center gap-2.5">
                                <span class="flex size-9 items-center justify-center rounded-full bg-subtle text-xs font-semibold text-title-foreground" x-text="initials"></span>
                                <span class="flex flex-col">
                                    <span class="text-[13px] font-medium text-title-foreground" x-text="name"></span>
                                    <span class="text-xs text-muted-foreground" x-text="role"></span>
                                </span>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs text-muted-foreground">
                                <span aria-hidden="true" class="iconify ph--buildings"></span><span x-text="company"></span>
                            </span>
                            <div class="flex gap-2">
                                <x-ui.button size="xs" variant="outline" intent="gray" class="h-7 flex-1 justify-center rounded-md text-xs text-title-foreground">Email</x-ui.button>
                                <x-ui.button size="xs" variant="soft" class="h-7 flex-1 justify-center rounded-md text-xs">Call</x-ui.button>
                            </div>
                        </x-ui.card>
                    </template>
                </div>
            </div>

            {{-- Tasks --}}
            <div x-show="page === 'tasks'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="flex flex-col">
                        <span class="text-lg font-semibold text-title-foreground">Tasks</span>
                        <span class="text-xs text-muted-foreground" x-text="openTasks + ' open · ' + (tasks.length - openTasks) + ' done'"></span>
                    </span>
                    <x-ui.button size="xs" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs">
                        <span aria-hidden="true" class="iconify ph--plus"></span>New task
                    </x-ui.button>
                </div>
                <x-ui.card class="overflow-hidden rounded-xl p-0 shadow-none">
                    <template x-for="task in tasks" :key="task.title">
                        <button type="button" role="checkbox" x-bind:aria-checked="task.done" x-on:click="task.done = !task.done"
                            class="flex h-11 w-full cursor-pointer items-center gap-3 border-b border-border/60 px-3.5 text-left last:border-0 hover:bg-surface">
                            <span x-bind:class="task.done ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-border-strong'"
                                class="flex size-4.5 shrink-0 items-center justify-center rounded-full border-[1.5px] transition-colors">
                                <span aria-hidden="true" class="iconify ph--check text-[10px]" x-show="task.done"></span>
                            </span>
                            <span class="flex-1 text-[13px]" x-text="task.title"
                                x-bind:class="task.done ? 'text-muted-foreground line-through' : 'text-title-foreground'"></span>
                            <span class="hidden rounded-full bg-subtle px-2 text-[11px] text-foreground sm:inline" x-text="task.tag"></span>
                            <span class="w-10 text-right text-xs text-muted-foreground" x-text="task.due"></span>
                        </button>
                    </template>
                </x-ui.card>
            </div>

            {{-- Pages sans contenu dans la démo --}}
            <template x-if="empty[page]">
                <div class="flex h-full flex-col items-center justify-center gap-2 py-16 text-center">
                    <span class="flex size-11 items-center justify-center rounded-full bg-subtle text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--package text-lg"></span>
                    </span>
                    <span class="mt-1 text-sm font-semibold text-title-foreground" x-text="empty[page].title"></span>
                    <span class="max-w-70 text-[13px] text-muted-foreground" x-text="empty[page].text"></span>
                    <x-ui.button size="xs" class="mt-2 h-8 gap-1.5 rounded-lg px-3 text-xs">
                        <span aria-hidden="true" class="iconify ph--plus"></span><span x-text="empty[page].cta"></span>
                    </x-ui.button>
                </div>
            </template>
        </div>
    </main>
</div>
