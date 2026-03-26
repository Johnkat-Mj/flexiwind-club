<div class="max-w-7xl px-4 mx-auto">
    <div class="grid gap-4 md:grid-cols-3">
        <x-ui.card class="sm:[--card-padding:--spacing(6)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-fg-muted">
                    Monthly Recurring Revenue
                </h3>
                <x-ui.badge variant="subtle" intent="success" size="sm">+8.2%</x-ui.badge>
            </div>
            <div class="space-y-2">
                <div class="text-2xl font-semibold text-fg-title">$12,426</div>
                <div class="text-xs text-fg-muted">Target: $15,000</div>
            </div>
            <div>
                <div class="flex justify-between text-xs">
                    <span class="text-fg-muted">Progress</span>
                    <span class="font-medium text-fg-title">83%</span>
                </div>
                <x-ui.progress size="xs" max="100" value="83" class="text-primary" />
            </div>
        </x-ui.card>

        <x-ui.card class="sm:[--card-padding:--spacing(6)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-fg-muted">
                    Customer Acquisition Cost
                </h3>
                <x-ui.badge variant="subtle" intent="danger" size="sm">+$12</x-ui.badge>
            </div>
            <div class="space-y-2">
                <div class="text-2xl font-semibold text-fg-title">$89</div>
                <div class="text-xs text-fg-muted">Target: $75</div>
            </div>
            <div>
                <div class="flex justify-between text-xs">
                    <span class="text-fg-muted">Progress</span>
                    <span class="font-medium text-fg-title">119%</span>
                </div>
                <x-ui.progress size="xs" max="100" value="100" class="text-success" />
            </div>
        </x-ui.card>

        <x-ui.card class="sm:[--card-padding:--spacing(6)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-fg-muted">
                    Customer Lifetime Value
                </h3>
                <x-ui.badge variant="subtle" intent="success" size="sm">+$47</x-ui.badge>
            </div>
            <div class="space-y-2">
                <div class="text-2xl font-semibold text-fg-title">$1,247</div>
                <div class="text-xs text-fg-muted">Target: $1,200</div>
            </div>
            <div>
                <div class="flex justify-between text-xs">
                    <span class="text-fg-muted">Progress</span>
                    <span class="font-medium text-fg-title">104%</span>
                </div>
                <x-ui.progress size="xs" max="100" value="100" class="text-success" />
            </div>
        </x-ui.card>
    </div>
</div>
