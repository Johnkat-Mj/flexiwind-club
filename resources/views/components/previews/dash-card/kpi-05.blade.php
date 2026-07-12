<div class="max-w-7xl px-4 w-full mx-auto">
    <div class=" grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <x-ui.card class="shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm font-normal">
                <x-ui.icon size="none" name="ph--check-circle" class="size-4.5" /> Completed task
            </div>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-medium text-fg-title tracking-tight">5,324</span>
                <x-ui.badge size="xs" variant="subtle" intent="success" class="flex items-center">
                    <x-ui.icon size="none" name="ph--trend-up" class="mr-1 size-2" /> 13%
                </x-ui.badge>
            </div>
            <p class="text-xs text-fg-muted/70 font-light">Last month completed 1,231 task</p>
        </x-ui.card>


        <x-ui.card class="shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm font-normal">
                <x-ui.icon size="none" name="ph--warning" class="size-4.5" /> Incomplete task
            </div>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-medium text-fg-title tracking-tight">152</span>
                <x-ui.badge size="xs" variant="subtle" intent="success" class="flex items-center">
                    <x-ui.icon size="none" name="ph--trend-up" class="mr-1 size-2" /> 25%
                </x-ui.badge>
            </div>
            <p class="text-xs text-fg-muted/70 font-light">Last month Incomplete 121 task</p>
        </x-ui.card>


        <x-ui.card class="shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm font-normal">
                <x-ui.icon size="none" name="ph--timer" class="size-4.5" /> Overdue task
            </div>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-medium text-fg-title tracking-tight">117</span>
                <x-ui.badge size="xs" variant="subtle" intent="success" class="flex items-center">
                    <x-ui.icon size="none" name="ph--trend-up" class="mr-1 size-2" /> 16%
                </x-ui.badge>
            </div>
            <p class="text-xs text-fg-muted/70 font-light">Last month overdue 31 task</p>
        </x-ui.card>


        <x-ui.card class="shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm font-normal">
                <x-ui.icon size="none" name="ph--timer" class="size-4.5" /> Overdue task
                {{-- solar:hourglass-linear --}}
            </div>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-medium text-fg-title tracking-tight">8h</span>
                <x-ui.badge size="xs" variant="subtle" intent="success" class="flex items-center">
                    <x-ui.icon size="none" name="ph--trend-up" class="mr-1 size-2" /> 42%
                </x-ui.badge>
            </div>
            <p class="text-xs text-fg-muted/70 font-light">Last month average 7h</p>
        </x-ui.card>
    </div>
</div>
