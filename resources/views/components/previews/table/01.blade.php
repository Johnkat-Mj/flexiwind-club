<div class="max-w-7xl px-4 mx-auto">
    <div class="flex flex-col sm:flex-row sm:justify-between items-center pb-4 gap-4">
        <div class="flex-1 flex items-center gap-1.5">
            <x-ui.input.group class="flex-1 max-w-xs">
                <x-ui.input variant="unstyled" placeholder="Start typing..." class="px-3 ps-8" />
                <x-ui.input.leading absolute>
                    <x-ui.icon name="ph--magnifying-glass" />
                </x-ui.input.leading>
            </x-ui.input.group>
            <x-ui.popover.trigger popover-id="filter" variant="ghost"
                class="size-9 d-flex-place-center border border-border-input">
                <x-ui.icon name="ph--funnel" />
            </x-ui.popover.trigger>
            <x-ui.popover id="filter" class="w-64">

            </x-ui.popover>
        </div>
        <div class="w-full sm:w-max">
            <x-ui.button size="sm" class="w-full justify-center sm:h-9">
                <x-ui.icon name="ph--plus" class="mr-2"/>
                Add Task
            </x-ui.button>
        </div>
    </div>
    <x-ui.table hoverable wrapper=" rounded-ui border border-border" class="text-left">
        <x-ui.table.columns
            wrapper="bg-bg-surface border-b border-border-input [--gutter-x:--spacing(4)] [--gutter-y:--spacing(3)]">
            <x-ui.table.column class="text-xs font-medium text-fg-muted uppercase tracking-wider w-8">
                <span aria-hidden="true" class="size-3.5 iconify ph--chart-bar mr-1"></span>
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                Task Name
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                <span class="flex items-center text-nowrap">
                    <span aria-hidden="true" class="size-3.5 iconify ph--file-dashed mr-1"></span> Descriptions
                </span>
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                <span class="flex items-center text-nowrap">
                    <span aria-hidden="true" class="size-3.5 iconify ph--users mr-1"></span> People
                </span>
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                <span class="flex items-center text-nowrap">
                    <span aria-hidden="true" class="size-3.5 iconify ph--align-bottom-light mr-1"></span> Type
                </span>
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                <span class="flex items-center text-nowrap">
                    <span aria-hidden="true" class="size-3.5 iconify ph--calendar mr-1"></span> Timeline Date
                </span>
            </x-ui.table.column>
            <x-ui.table.column class="text-xs">
                <span class="flex items-center text-nowrap">
                    <span aria-hidden="true" class="size-3.5 iconify ph--flag mr-1"></span> Priority
                </span>
            </x-ui.table.column>
            <x-ui.table.column class="w-10"></x-ui.table.column>
        </x-ui.table.columns>
        <x-ui.table.rows class="[--gutter-x:--spacing(4)] [--gutter-y:--spacing(3)]">
            <x-ui.table.row hoverable class="group">
                <x-ui.table.cell>
                    <span
                        class="text-fg-muted cursor-move size-4 iconify ph--dots-six-vertical opacity-40 group-hover:opacity-80"></span>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <div class="flex items-center gap-3">
                        <x-ui.checkbox />
                        <span class="text-sm font-medium text-fg-title truncate">Redesign Login Page</span>
                    </div>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <span class="text-sm text-fg-muted">Implement kanban-style...</span>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <div class="flex -space-x-2">
                        <x-ui.avatar src="/avatar1.webp" size="xs" alt="user avatar" width="20" height="20"
                            class="ring-2 ring-border" />
                        <x-ui.avatar src="/avatar2.webp" size="xs" alt="user avatar" width="20" height="20"
                            class="ring-2 ring-border" />
                        <div
                            class="size-6.5 rounded-full bg-bg-surface ring-2 ring-border text-xs d-flex-place-center text-fg-muted">
                            +3
                        </div>
                    </div>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <x-ui.badge variant="subtle" intent="danger" size="sm"
                        class="d-flex-items-center gap-x-1 w-max">
                        <span aria-hidden="true" class="flex iconify ph--pencil-ruler"></span>
                        Design
                    </x-ui.badge>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <span class="text-sm text-fg-muted">Apr 17 - May 15 '25</span>
                </x-ui.table.cell>
                <x-ui.table.cell>
                    <div class="flex items-center gap-1.5">
                        <span aria-hidden="true" class="size-3.5 iconify ph--flag-banner-fill text-danger"></span>
                        <span class="text-sm font-medium text-fg-title">High</span>
                    </div>
                </x-ui.table.cell>
                <x-ui.table.cell class="text-right">
                    <x-ui.button size="sm" icon-only variant="ghost">
                        <span aria-hidden="true" class="iconify ph--dots-three"></span>
                    </x-ui.button>
                </x-ui.table.cell>
            </x-ui.table.row>
        </x-ui.table.rows>
    </x-ui.table>
    <div class="pt-3 flex items-center justify-between">
        <div class="">
            Showing <span>1</span> of <span>4</span> Pages
        </div>
        <div class="">

        </div>
    </div>
</div>
