{{--
    Démo du Livewire Starter : réglages, notes, calendrier et tâches. L'onglet
    Appearance change réellement le thème de l'aperçu.
--}}
@php
    $notes = [
        ['Planning', 'Q4 roadmap', 'Ship the billing page, then the onboarding flow.', 'Edited 2h ago'],
        ['Meeting', 'Client kickoff', 'Agenda, owners and the first milestone date.', 'Yesterday'],
        ['Idea', 'Weekly digest', 'Send a Monday summary of open tasks per member.', 'Mon'],
        ['Design', 'Empty states', 'One illustration per section, same tone of voice.', 'Sep 21'],
        ['Ops', 'Backups', 'Nightly database dump to the storage bucket.', 'Sep 18'],
        ['Planning', 'Hiring', 'Two Laravel developers before the end of the year.', 'Sep 12'],
    ];
    $events = [3 => 'Kickoff', 9 => 'Design review', 16 => 'Release v1', 23 => 'Retro'];
    $members = [
        ['J', 'Jack', 'jack@unoplanner.test', 'Owner'],
        ['AD', 'Amara Diallo', 'amara@unoplanner.test', 'Editor'],
        ['KS', 'Kenji Sato', 'kenji@unoplanner.test', 'Viewer'],
    ];
@endphp

<div x-data="starterDemo" x-on:demo-go.window="go($event.detail)" x-bind:class="themeClass" class="flex size-full bg-background text-foreground">
    <aside class="hidden w-54 shrink-0 flex-col gap-0.5 border-r border-border bg-surface px-3 py-3.5 md:flex">
        <div class="mb-3 flex items-center gap-2 rounded-lg border border-border bg-background p-2">
            <span class="flex size-7 items-center justify-center rounded-md bg-gray-900 text-xs font-bold text-white dark:bg-white dark:text-gray-950">U</span>
            <span class="flex-1 text-[13px] font-semibold text-title-foreground">UnoPlanner</span>
            <span aria-hidden="true" class="iconify ph--caret-up-down text-xs text-muted-foreground"></span>
        </div>
        <span class="px-2.5 pb-1 text-[11px] font-medium text-muted-foreground">Navigation</span>
        @foreach ([['notes', 'ph--note', 'Notes'], ['calendar', 'ph--calendar-blank', 'Calendar'], ['tasks', 'ph--check-square', 'Tasks']] as [$page, $icon, $label])
            <button type="button" x-on:click="go('{{ $page }}')"
                x-bind:class="page === '{{ $page }}' ? 'bg-background text-title-foreground font-medium shadow-xs ring-1 ring-border' : 'text-foreground hover:bg-subtle'"
                class="flex h-8.5 w-full cursor-pointer items-center gap-2.5 rounded-lg px-2.5 text-[13px]">
                <span aria-hidden="true" class="iconify {{ $icon }} text-sm"></span>{{ $label }}
            </button>
        @endforeach
        <div class="mt-auto flex flex-col gap-2">
            <button type="button" x-on:click="go('settings')"
                x-bind:class="page === 'settings' ? 'bg-background text-title-foreground font-medium shadow-xs ring-1 ring-border' : 'text-foreground hover:bg-subtle'"
                class="flex h-8.5 w-full cursor-pointer items-center gap-2.5 rounded-lg px-2.5 text-[13px]">
                <span aria-hidden="true" class="iconify ph--gear-six text-sm"></span>Settings
            </button>
            <div class="flex items-center gap-2 rounded-lg border border-border bg-background p-2">
                <span class="flex size-7 items-center justify-center rounded-full bg-subtle text-[11px] font-semibold text-title-foreground">J</span>
                <span class="flex min-w-0 flex-col">
                    <span class="truncate text-xs font-medium text-title-foreground" x-text="displayName">Jack</span>
                    <span class="truncate text-[11px] text-muted-foreground">jack@unoplanner.test</span>
                </span>
            </div>
        </div>
    </aside>

    <main class="flex min-w-0 flex-1 flex-col">
        <div class="flex h-12 shrink-0 items-center justify-between border-b border-border px-4">
            <span class="flex items-center gap-1.5 text-[13px] text-muted-foreground">
                Core
                <span aria-hidden="true" class="iconify ph--caret-right text-xs text-border-strong"></span>
                <span class="font-medium text-title-foreground" x-text="titles[page]"></span>
            </span>
            <span class="flex items-center gap-3 text-muted-foreground">
                <span aria-hidden="true" class="iconify ph--magnifying-glass text-sm"></span>
                <span aria-hidden="true" class="iconify ph--bell text-sm"></span>
            </span>
        </div>

        <div class="min-h-0 flex-1 overflow-auto p-4 sm:p-6">
            {{-- Settings --}}
            <div x-show="page === 'settings'" class="flex flex-col">
                <span class="font-display text-xl font-semibold text-title-foreground">Settings</span>
                <span class="mt-1 text-[13px] text-muted-foreground">Manage your profile and account settings.</span>
                <div class="my-5 h-px bg-border"></div>
                <div class="flex flex-col gap-6 lg:flex-row">
                    <div class="flex gap-1 overflow-x-auto lg:w-40 lg:flex-col">
                        @foreach (['profile' => 'Profile', 'security' => 'Security', 'appearance' => 'Appearance', 'teams' => 'Teams'] as $key => $label)
                            <button type="button" x-on:click="tab = '{{ $key }}'"
                                x-bind:class="tab === '{{ $key }}' ? 'bg-subtle text-title-foreground font-medium' : 'text-foreground hover:bg-subtle/60'"
                                class="h-8 shrink-0 cursor-pointer rounded-lg px-2.5 text-left text-[13px]">{{ $label }}</button>
                        @endforeach
                    </div>
                    <div class="max-w-md flex-1">
                        <div x-show="tab === 'profile'" class="flex flex-col gap-4">
                            <span class="flex flex-col gap-0.5">
                                <span class="text-sm font-semibold text-title-foreground">Profile</span>
                                <span class="text-[13px] text-muted-foreground">Update your name and email address.</span>
                            </span>
                            <x-ui.input label="Name" id="starter-name" x-model="name" placeholder="Jack" size="sm" />
                            <x-ui.input label="Email" id="starter-email" type="email" placeholder="jack@unoplanner.test" size="sm" />
                            <x-ui.button size="sm" intent="neutral" x-on:click="save()" class="w-max rounded-lg">
                                <span x-text="saved ? 'Saved' : 'Save'">Save</span>
                            </x-ui.button>
                            <div class="mt-3 flex flex-col gap-2 rounded-xl border border-destructive/25 bg-destructive/5 p-4">
                                <span class="text-sm font-semibold text-destructive">Delete account</span>
                                <span class="text-[13px] text-muted-foreground">Delete your account and all of its resources.</span>
                                <x-ui.button size="sm" intent="danger" class="w-max rounded-lg">Delete account</x-ui.button>
                            </div>
                        </div>
                        <div x-show="tab === 'security'" x-cloak class="flex flex-col gap-4">
                            <span class="flex flex-col gap-0.5">
                                <span class="text-sm font-semibold text-title-foreground">Update password</span>
                                <span class="text-[13px] text-muted-foreground">Use a long, random password to stay secure.</span>
                            </span>
                            <x-ui.input label="Current password" id="starter-current" type="password" size="sm" />
                            <x-ui.input label="New password" id="starter-new" type="password" size="sm" />
                            <x-ui.input label="Confirm password" id="starter-confirm" type="password" size="sm" />
                            <x-ui.button size="sm" intent="neutral" class="w-max rounded-lg">Save password</x-ui.button>
                        </div>
                        <div x-show="tab === 'appearance'" x-cloak class="flex flex-col gap-4">
                            <span class="flex flex-col gap-0.5">
                                <span class="text-sm font-semibold text-title-foreground">Appearance</span>
                                <span class="text-[13px] text-muted-foreground">Pick a theme — this preview switches with it.</span>
                            </span>
                            <div role="radiogroup" aria-label="Theme" class="flex flex-wrap gap-3">
                                @foreach (['light' => ['Light', 'bg-gray-100', 'bg-gray-300'], 'dark' => ['Dark', 'bg-gray-900', 'bg-gray-700'], 'system' => ['System', 'bg-linear-to-r from-gray-100 from-50% to-gray-900 to-50%', 'bg-gray-400']] as $key => [$label, $ground, $bar])
                                    <button type="button" role="radio" x-bind:aria-checked="theme === '{{ $key }}'" x-on:click="theme = '{{ $key }}'"
                                        x-bind:class="theme === '{{ $key }}' ? 'border-primary ring-3 ring-primary/20' : 'border-border'"
                                        class="flex w-30 cursor-pointer flex-col gap-2 rounded-[10px] border bg-background p-2 text-left">
                                        <span class="flex h-14.5 flex-col gap-1.5 rounded-md p-2.25 {{ $ground }}">
                                            <span class="block h-1.75 w-[62%] rounded-full {{ $bar }}"></span>
                                            <span class="block h-1.75 w-[38%] rounded-full {{ $bar }}"></span>
                                        </span>
                                        <span class="text-xs font-medium text-title-foreground">{{ $label }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div x-show="tab === 'teams'" x-cloak class="flex flex-col gap-4">
                            <span class="flex items-start justify-between gap-3">
                                <span class="flex flex-col gap-0.5">
                                    <span class="text-sm font-semibold text-title-foreground">Team members</span>
                                    <span class="text-[13px] text-muted-foreground">People who can open this workspace.</span>
                                </span>
                                <x-ui.button size="xs" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs">
                                    <span aria-hidden="true" class="iconify ph--plus"></span>Invite
                                </x-ui.button>
                            </span>
                            <x-ui.card class="overflow-hidden rounded-xl p-0 shadow-none">
                                @foreach ($members as [$initials, $member, $email, $role])
                                    <div class="flex items-center gap-3 border-b border-border/60 px-3.5 py-2.5 last:border-0">
                                        <span class="flex size-8 items-center justify-center rounded-full bg-subtle text-[11px] font-semibold text-title-foreground">{{ $initials }}</span>
                                        <span class="flex min-w-0 flex-1 flex-col">
                                            <span class="text-[13px] font-medium text-title-foreground">{{ $member }}</span>
                                            <span class="truncate text-xs text-muted-foreground">{{ $email }}</span>
                                        </span>
                                        <x-ui.badge size="sm" variant="soft" :intent="$role === 'Owner' ? 'primary' : 'gray'">{{ $role }}</x-ui.badge>
                                    </div>
                                @endforeach
                            </x-ui.card>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div x-show="page === 'notes'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="font-display text-xl font-semibold text-title-foreground">Notes</span>
                    <x-ui.button size="xs" intent="neutral" class="h-7.5 gap-1.5 rounded-lg px-2.5 text-xs">
                        <span aria-hidden="true" class="iconify ph--plus"></span>New note
                    </x-ui.button>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($notes as [$tag, $title, $text, $when])
                        <x-ui.card class="flex flex-col gap-1.5 rounded-xl p-4 shadow-none">
                            <x-ui.badge size="xs" variant="soft" intent="gray" class="w-max">{{ $tag }}</x-ui.badge>
                            <span class="mt-1 text-sm font-semibold text-title-foreground">{{ $title }}</span>
                            <span class="text-[13px] text-muted-foreground">{{ $text }}</span>
                            <span class="mt-1 text-[11.5px] text-subtitle">{{ $when }}</span>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>

            {{-- Calendar --}}
            <div x-show="page === 'calendar'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="font-display text-xl font-semibold text-title-foreground">September 2026</span>
                    <div class="flex gap-1">
                        <x-ui.button size="xs" variant="outline" intent="gray" icon-only aria-label="Previous month" class="size-7.5 rounded-lg">
                            <span aria-hidden="true" class="iconify ph--caret-left"></span>
                        </x-ui.button>
                        <x-ui.button size="xs" variant="outline" intent="gray" icon-only aria-label="Next month" class="size-7.5 rounded-lg">
                            <span aria-hidden="true" class="iconify ph--caret-right"></span>
                        </x-ui.button>
                    </div>
                </div>
                <div class="overflow-hidden rounded-xl border border-border">
                    <div class="grid grid-cols-7 border-b border-border bg-surface text-center text-[11.5px] font-medium text-muted-foreground">
                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            <span class="py-2">{{ $day }}</span>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7">
                        @foreach (array_merge(range(1, 30), range(1, 5)) as $index => $day)
                            <div @class(['flex min-h-16 flex-col gap-1 border-r border-b border-border/70 p-1.5 text-xs [&:nth-child(7n)]:border-r-0', 'text-subtitle' => $index >= 30, 'text-title-foreground' => $index < 30])>
                                <span>{{ $day }}</span>
                                @if ($index < 30 && isset($events[$day]))
                                    <span class="truncate rounded-md bg-primary/12 px-1.5 py-0.5 text-[10.5px] font-medium text-primary">{{ $events[$day] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tasks --}}
            <div x-show="page === 'tasks'" x-cloak class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="font-display text-xl font-semibold text-title-foreground">Tasks</span>
                    <span class="text-xs text-muted-foreground" x-text="openTasks + ' open'"></span>
                </div>
                <x-ui.card class="overflow-hidden rounded-xl p-0 shadow-none">
                    <template x-for="task in tasks" :key="task.title">
                        <button type="button" role="checkbox" x-bind:aria-checked="task.done" x-on:click="task.done = !task.done"
                            class="flex h-11 w-full cursor-pointer items-center gap-3 border-b border-border/60 px-3.5 text-left last:border-0 hover:bg-surface">
                            <span x-bind:class="task.done ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-border-strong'"
                                class="flex size-4.5 shrink-0 items-center justify-center rounded-full border-[1.5px]">
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
        </div>
    </main>
</div>
