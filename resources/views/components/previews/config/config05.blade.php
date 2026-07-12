<div class="max-w-2xl w-full p-4 mx-auto">
    <div class="bg-bg border border-border-strong/40 ring-2 ring-border rounded-lg">
        <div class="p-6 border-b border-border bg-bg-surface">
            <h4 class="text-lg font-semibold text-fg-title">
                Two-Factor Authentication
            </h4>
            <p class="text-sm text-fg">
                Add an extra layer of security to your account
            </p>
        </div>
        <div class="p-6 grid gap-4">
            <div class="flex items-center justify-between p-4 border border-border-strong/60 rounded-lg">
                <div class="space-y-1 flex-1">
                    <h5 class="font-medium text-fg-title">
                        SMS Authentication
                    </h5>
                    <p class="text-sm text-fg-muted">
                        Receive verification codes via SMS
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-fg-muted">Enabled</span>
                    <x-ui.button variant="soft" size="sm" class="border border-border-strong/60">
                        Configure
                    </x-ui.button>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 border border-border-strong/60 rounded-lg">
                <div class="space-y-1 flex-1">
                    <h5 class="font-medium text-fg-title">
                        Authenticator App
                    </h5>
                    <p class="text-sm text-fg-muted">
                        Use an authenticator app for verification
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-fg-muted">Not configured</span>
                    <x-ui.button size="sm">
                        Setup
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
