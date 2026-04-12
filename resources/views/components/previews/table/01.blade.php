@php
    $statusIntents = [
        'Actif' => 'success',
        'Inactif' => 'danger',
        'Pending' => 'warning',
    ];

    $leads = [
        [
            'id' => 'lead_1',
            'name' => 'John Smith',
            'phone' => '+243 81 234 5678',
            'email' => 'johndow@gmail.com',
            'status' => 'Actif',
            'source' => ['icon' => 'ph--link', 'label' => 'Website'],
            'assignees' => 3,
        ],
        [
            'id' => 'lead_2',
            'name' => 'Michael Brown',
            'phone' => '+243 80 345 6789',
            'email' => 'michael.brown@example.com',
            'status' => 'Inactif',
            'source' => ['icon' => 'ph--link', 'label' => 'LinkedIn'],
            'assignees' => 1,
        ],
        [
            'id' => 'lead_3',
            'name' => 'Amina Diallo',
            'phone' => '+243 84 321 7654',
            'email' => 'amina.d@example.com',
            'status' => 'Actif',
            'source' => ['icon' => 'ph--link', 'label' => 'GitHub'],
            'assignees' => 2,
        ],
        [
            'id' => 'lead_4',
            'name' => 'Carlos Méndez',
            'phone' => '+243 82 222 3333',
            'email' => 'carlos.mendez@example.com',
            'status' => 'Pending',
            'source' => ['icon' => 'ph--link', 'label' => 'Resume'],
            'assignees' => 1,
        ],
        [
            'id' => 'lead_5',
            'name' => 'Fatima Ibrahim',
            'phone' => '+243 88 555 1234',
            'email' => 'fatima.ibrahim@example.com',
            'status' => 'Actif',
            'source' => ['icon' => 'ph--link', 'label' => 'Portfolio'],
            'assignees' => 2,
        ],
        [
            'id' => 'lead_6',
            'name' => 'Samuel Lee',
            'phone' => '+243 89 444 6789',
            'email' => 'sam.lee@example.com',
            'status' => 'Inactif',
            'source' => ['icon' => 'ph--linkedin-logo', 'label' => 'LinkedIn'],
            'assignees' => 1,
        ],
        [
            'id' => 'lead_7',
            'name' => 'Nina Kamanzi',
            'phone' => '+243 85 666 4321',
            'email' => 'nina.kamanzi@example.com',
            'status' => 'Actif',
            'source' => ['icon' => 'ph--link', 'label' => 'Blog'],
            'assignees' => 2,
        ],
        [
            'id' => 'lead_8',
            'name' => 'Alex Kimani',
            'phone' => '+243 87 111 2345',
            'email' => 'alex.kimani@example.com',
            'status' => 'Pending',
            'source' => ['icon' => 'ph--link', 'label' => 'Website'],
            'assignees' => 1,
        ],
        [
            'id' => 'lead_9',
            'name' => 'Grace Chen',
            'phone' => '+243 83 999 8888',
            'email' => 'grace.chen@example.com',
            'status' => 'Actif',
            'source' => ['icon' => 'ph--link', 'label' => 'Profile'],
            'assignees' => 2,
        ],
    ];

    $perPageOptions = [5, 10, 15, 20, 25];
@endphp

<div class="max-w-7xl px-4 mx-auto">
    <div class="flex items-center md:justify-between gap-4 pb-2 border-b border-dashed border-border-strong/80">
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-ui d-flex-place-center ui-subtle ui-subtle-gray">
                <span aria-hidden="true" class="iconify ph--users"></span>
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-fg-title">Leads</h3>
                <p class="text-fg-muted text-sm">Summary of leads</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button href="./nouveau.html" variant="solid" intent="primary" size="sm">
                <span aria-hidden="true" class="iconify ph--plus mr-2"></span>
                New lead
            </x-ui.button>
        </div>
    </div>
    <div class="mt-6 grid overflow-hidden w-full rounded-lg border border-border-strong/60">
        <div class="flex items-center justify-between p-4">
            <x-ui.input.group class="max-w-xs flex-1">
                <x-ui.input variant="unstyled" placeholder="Search" class="ps-9 pe-10" />
                <x-ui.input.leading absolute>
                    <span aria-hidden="true" class="iconify ph--magnifying-glass text-fg-muted opacity-80"></span>
                </x-ui.input.leading>
            </x-ui.input.group>
            <label class="flex items-center gap-2">
                <x-ui.select name="per-page">
                    @foreach ($perPageOptions as $option)
                        <x-ui.select.option :value="$option" :label="$option" :selected="$option === 10" />
                    @endforeach
                </x-ui.select>
                <span class="hidden md:inline text-nowrap text-sm text-fg-muted">entries per page</span>
            </label>
        </div>

        <x-ui.table wrapper="border-t border-border-strong/60">
            <x-ui.table.columns class="bg-bg-surface border-b border-border-input/60">
                <x-ui.table.column class="w-5" whiteSpace="normal">
                    <x-ui.checkbox name="select_all" id="select_all" />
                </x-ui.table.column>
                <x-ui.table.column>Name</x-ui.table.column>
                <x-ui.table.column>Contact</x-ui.table.column>
                <x-ui.table.column>Status</x-ui.table.column>
                <x-ui.table.column>Source</x-ui.table.column>
                <x-ui.table.column>Assign to</x-ui.table.column>
                <x-ui.table.column class="w-8"></x-ui.table.column>
            </x-ui.table.columns>
            <x-ui.table.rows>
                @foreach ($leads as $lead)
                    <x-ui.table.row :hoverable="true">
                        <x-ui.table.cell class="w-5" whiteSpace="normal">
                            <x-ui.checkbox :name="$lead['id']" :id="$lead['id']" />
                        </x-ui.table.cell>
                        <x-ui.table.cell>
                            <span class="text-fg-title">
                                {{ $lead['name'] }}
                            </span>
                        </x-ui.table.cell>
                        <x-ui.table.cell whiteSpace="normal">
                            <div class="flex flex-col">
                                <span class="text-sm text-fg-title">{{ $lead['phone'] }}</span>
                                <span class="text-sm text-fg-muted">{{ $lead['email'] }}</span>
                            </div>
                        </x-ui.table.cell>
                        <x-ui.table.cell>
                            <x-ui.badge variant="subtle" :intent="$statusIntents[$lead['status']]" size="sm">
                                {{ $lead['status'] }}
                            </x-ui.badge>
                        </x-ui.table.cell>
                        <x-ui.table.cell>
                            <span class="flex items-center text-sm gap-2">
                                <span aria-hidden="true" class="iconify {{ $lead['source']['icon'] }}"></span>
                                {{ $lead['source']['label'] }}
                            </span>
                        </x-ui.table.cell>
                        <x-ui.table.cell>
                            <div class="flex items-center -space-x-3">
                                @for ($i = 0; $i < $lead['assignees']; $i++)
                                    <x-ui.avatar src="/defaultavatar.webp" alt="Avatar user" size="sm" />
                                @endfor
                            </div>
                        </x-ui.table.cell>
                        <x-ui.table.cell class="w-8">
                            <x-ui.button variant="ghost" intent="gray" :icon-only="true" size="sm">
                                <span aria-hidden="true" class="iconify ph--dots-three-vertical"></span>
                            </x-ui.button>
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.rows>
        </x-ui.table>
        <div class="p-4 border-t border-border-strong/60 flex items-center justify-between">
            <span class="text-fg-muted text-xs sm:text-sm">
                Showing 1 to {{ count($leads) }} entries
            </span>
            <div class="flex items-center gap-2">
                <x-ui.button variant="outline" intent="gray" size="sm">
                    <span aria-hidden="true" class="iconify ph--caret-left mr-2"></span>
                    Prev
                </x-ui.button>
                <x-ui.button variant="outline" intent="gray" size="sm">
                    Next
                    <span aria-hidden="true" class="iconify ph--caret-right ml-2"></span>
                </x-ui.button>
            </div>
        </div>
    </div>
</div>
