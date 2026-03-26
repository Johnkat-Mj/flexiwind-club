<x-ui.card size="none" class="rounded-ui mx-auto max-w-sm">
    <div class="p-3 sm:p-4 ">
        <h4 class="text-lg font-semibold">System Activity Log</h4>
    </div>
    <div class="px-3 pb-3 sm:px-4 sm:pb-4">
        <div class="space-y-3">
            <x-ui.card size="none" class="flex flex-col space-y-1 p-3 rounded-ui">
                <div class="flex items-center justify-between space-x-3">
                    <span class="font-medium text-fg flex-1">User Registration</span>
                    <x-ui.badge size="sm" variant="soft" intent="success">
                        Success
                    </x-ui.badge>
                </div>
                <p class="text-sm text-fg-muted">
                    New user john.doe@example.com registered
                </p>
                <div class="flex items-center space-x-4 text-xs text-fg-muted">
                    <span>2024-01-15 14:32:01</span>
                    <span>IP: 192.168.1.100</span>
                </div>
            </x-ui.card>
            <x-ui.card size="none" class="flex flex-col space-y-1 p-3 rounded-ui">
                <div class="flex items-center justify-between space-x-3">
                    <span class="font-medium text-fg flex-1">Payment Processed</span>
                    <x-ui.badge size="sm" variant="soft" intent="success">
                        Success
                    </x-ui.badge>
                </div>
                <p class="text-sm text-fg-muted">
                    Payment of $99.00 processed for Order #12345
                </p>
                <div class="flex items-center space-x-4 text-xs text-fg-muted">
                    <span>2024-01-15 14:28:15</span>
                    <span>IP: 10.0.0.45</span>
                </div>
            </x-ui.card>
            <x-ui.card size="none" class="flex flex-col space-y-1 p-3 rounded-ui">
                <div class="flex items-center justify-between space-x-3">
                    <span class="font-medium text-fg flex-1">Login Attempt</span>
                    <x-ui.badge size="sm" variant="soft" intent="danger">
                        Error
                    </x-ui.badge>
                </div>
                <p class="text-sm text-fg-muted">
                    Failed login attempt for admin@company.com
                </p>
                <div class="flex items-center space-x-4 text-xs text-fg-muted">
                    <span>2024-01-15 14:25:33</span>
                    <span>IP: 203.0.113.42</span>
                </div>
            </x-ui.card>
            <x-ui.card size="none" class="flex flex-col space-y-1 p-3 rounded-ui">
                <div class="flex items-center justify-between space-x-3">
                    <span class="font-medium text-fg flex-1">Data Export</span>
                    <x-ui.badge size="sm" variant="soft" intent="warning">
                        Warning
                    </x-ui.badge>
                </div>
                <p class="text-sm text-fg-muted">
                    User exported customer data (CSV format)
                </p>
                <div class="flex items-center space-x-4 text-xs text-fg-muted">
                    <span>2024-01-15 14:20:12</span>
                    <span>IP: 192.168.1.50</span>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-ui.card>
