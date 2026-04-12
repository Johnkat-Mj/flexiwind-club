@php
    $statusIntents = [
        'Actif'   => 'success',
        'Inactif' => 'danger',
        'Pending' => 'warning',
    ];

    $leads = [
        ['id' => 'lead_1', 'name' => 'John Smith',     'phone' => '+243 81 234 5678', 'email' => 'johndow@gmail.com',            'status' => 'Actif',   'source' => ['icon' => 'ph--link',          'label' => 'Website'],   'assignees' => 3],
        ['id' => 'lead_2', 'name' => 'Michael Brown',  'phone' => '+243 80 345 6789', 'email' => 'michael.brown@example.com',    'status' => 'Inactif', 'source' => ['icon' => 'ph--linkedin-logo', 'label' => 'LinkedIn'],  'assignees' => 1],
        ['id' => 'lead_3', 'name' => 'Amina Diallo',   'phone' => '+243 84 321 7654', 'email' => 'amina.d@example.com',          'status' => 'Actif',   'source' => ['icon' => 'ph--github-logo',   'label' => 'GitHub'],    'assignees' => 2],
        ['id' => 'lead_4', 'name' => 'Carlos Mendez',  'phone' => '+243 82 222 3333', 'email' => 'carlos.mendez@example.com',    'status' => 'Pending', 'source' => ['icon' => 'ph--link',          'label' => 'Resume'],    'assignees' => 1],
        ['id' => 'lead_5', 'name' => 'Fatima Ibrahim', 'phone' => '+243 88 555 1234', 'email' => 'fatima.ibrahim@example.com',   'status' => 'Actif',   'source' => ['icon' => 'ph--link',          'label' => 'Portfolio'], 'assignees' => 2],
        ['id' => 'lead_6', 'name' => 'Samuel Lee',     'phone' => '+243 89 444 6789', 'email' => 'sam.lee@example.com',          'status' => 'Inactif', 'source' => ['icon' => 'ph--linkedin-logo', 'label' => 'LinkedIn'],  'assignees' => 1],
        ['id' => 'lead_7', 'name' => 'Nina Kamanzi',   'phone' => '+243 85 666 4321', 'email' => 'nina.kamanzi@example.com',     'status' => 'Actif',   'source' => ['icon' => 'ph--link',          'label' => 'Blog'],      'assignees' => 2],
        ['id' => 'lead_8', 'name' => 'Alex Kimani',    'phone' => '+243 87 111 2345', 'email' => 'alex.kimani@example.com',      'status' => 'Pending', 'source' => ['icon' => 'ph--link',          'label' => 'Website'],   'assignees' => 1],
        ['id' => 'lead_9', 'name' => 'Grace Chen',     'phone' => '+243 83 999 8888', 'email' => 'grace.chen@example.com',       'status' => 'Actif',   'source' => ['icon' => 'ph--link',          'label' => 'Profile'],   'assignees' => 2],
    ];

    $pages = [1, 2, 3];
    $currentPage = 1;
@endphp

<div class="max-w-7xl px-4 mx-auto">
    <div class="grid overflow-hidden w-full p-5 rounded-lg border border-border-strong/60">
        <div class="flex pb-4 flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-col">
                <h3 class="font-semibold text-fg-title">Leads</h3>
                <p class="text-fg-muted text-sm">Summary of leads</p>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.input.group class="flex-1">
                    <x-ui.input.leading absolute>
                        <span aria-hidden="true" class="iconify ph--magnifying-glass text-fg-muted opacity-80"></span>
                    </x-ui.input.leading>
                    <x-ui.input variant="unstyled" placeholder="Search..." class="ps-9" />
                </x-ui.input.group>
                <x-ui.button variant="outline" intent="gray" size="sm" :icon-only="true">
                    <span aria-hidden="true" class="iconify ph--funnel"></span>
                </x-ui.button>
            </div>
        </div>

        <x-ui.table noDivider>
            <x-ui.table.columns class="*:bg-bg-muted/70 *:first:rounded-l-md *:last:rounded-r-md">
                <x-ui.table.column class="w-5" whiteSpace="normal">
                    <x-ui.checkbox name="select_all" id="select_all_03" />
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
                    <x-ui.table.cell>{{ $lead['name'] }}</x-ui.table.cell>
                    <x-ui.table.cell whiteSpace="normal">
                        <div class="flex flex-col">
                            <span class="text-sm text-fg-title">{{ $lead['phone'] }}</span>
                            <span class="text-sm text-fg-muted">{{ $lead['email'] }}</span>
                        </div>
                    </x-ui.table.cell>
                    <x-ui.table.cell>
                        <x-ui.badge variant="soft" :intent="$statusIntents[$lead['status']]">
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

        <div class="pt-4 border-t border-border-strong/60 flex items-center justify-between">
            <span class="text-fg-muted text-xs sm:text-sm truncate text-nowrap">
                Showing 1 to {{ count($leads) }} entries
            </span>
            <x-ui.pagination justify="end" class="flex-1">
                <x-ui.pagination.content>
                    <x-ui.pagination.item>
                        <x-ui.pagination.link href="#" aria-label="Prev page" aria-disabled="true">
                            <span aria-hidden="true" class="iconify ph--caret-left text-lg"></span>
                        </x-ui.pagination.link>
                    </x-ui.pagination.item>
                    @foreach ($pages as $page)
                        <x-ui.pagination.item>
                            <x-ui.pagination.link href="#" :isActive="$page === $currentPage">
                                {{ $page }}
                            </x-ui.pagination.link>
                        </x-ui.pagination.item>
                    @endforeach
                    <x-ui.pagination.item>
                        <x-ui.pagination.link href="#" aria-label="Next page">
                            <span aria-hidden="true" class="iconify ph--caret-right text-lg"></span>
                        </x-ui.pagination.link>
                    </x-ui.pagination.item>
                </x-ui.pagination.content>
            </x-ui.pagination>
        </div>
    </div>
</div>
