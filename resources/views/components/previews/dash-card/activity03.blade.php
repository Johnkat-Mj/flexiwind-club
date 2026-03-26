<x-ui.card size="none" class="rounded-ui mx-auto max-w-sm">
    <div class="flex items-center justify-between p-4 pb-4">
        <h4 class="text-lg font-semibold">Sales Activity</h4>
        <x-ui.button variant="outline" size="sm">
            View All
        </x-ui.button>
    </div>
    <div class="px-4 pb-4 space-y-4"> 
        <x-ui.card size="none"
            class="flex items-start space-x-4 p-3 rounded-ui hover:bg-bg-subtle/30 transition-colors">
            <div class="d-flex-place-center ui-soft ui-soft-gray rounded-ui size-10">
                <span aria-hidden="true" class="iconify ph--shopping-bag"></span>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-fg-title line-clamp-1">
                        Sarah Johnson placed a new order
                    </p>
                    <span class="text-sm font-semibold text-fg-title">$156.99</span>
                </div>
                <div class="flex items-center justify-between mt-1 text-xs text-fg-muted">
                    <p>3 items</p>
                    <p>5 minutes ago</p>
                </div>
            </div>
        </x-ui.card>
        <x-ui.card size="none"
            class="flex items-start space-x-4 p-3 rounded-ui hover:bg-bg-subtle/30 transition-colors">
            <div class="d-flex-place-center ui-soft ui-soft-gray rounded-ui size-10">
                <span aria-hidden="true" class="iconify ph--cardholder"></span>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-fg-title line-clamp-1">
                        Mike Chen payment received
                    </p>
                    <span class="text-sm font-semibold text-fg-title">$89.50</span>
                </div>
                <div class="flex items-center justify-between mt-1 text-xs text-fg-muted">
                    <p>3 items</p>
                    <p>12 minutes ago</p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card size="none"
            class="flex items-start space-x-4 p-3 rounded-ui hover:bg-bg-subtle/30 transition-colors">
            <div class="d-flex-place-center ui-soft ui-soft-gray rounded-ui size-10">
                <span aria-hidden="true" class="iconify ph--cardholder"></span>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-fg-title line-clamp-1">
                        Emma Davis placed a new order
                    </p>
                    <span class="text-sm font-semibold text-fg-title">$234.75</span>
                </div>
                <div class="flex items-center justify-between mt-1 text-xs text-fg-muted">
                    <p>5 items</p>
                    <p>28 minutes ago</p>
                </div>
            </div>
        </x-ui.card>

         <x-ui.card size="none"
            class="flex items-start space-x-4 p-3 rounded-ui hover:bg-bg-subtle/30 transition-colors">
            <div class="d-flex-place-center ui-soft ui-soft-gray rounded-ui size-10">
                <span aria-hidden="true" class="iconify ph--cardholder"></span>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-fg-title line-clamp-1">
                        Order #12846
                    </p>
                    <span class="text-sm font-semibold text-fg-title">$67.25</span>
                </div>
                <div class="flex items-center justify-between mt-1 text-xs text-fg-muted">
                    <p>5 items</p>
                    <p>1 Hour ago</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-ui.card>
