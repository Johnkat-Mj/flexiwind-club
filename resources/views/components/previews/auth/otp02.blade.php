<main class="min-h-screen d-flex-place-center px-4 sm:px-10 lg:px-0 py-6">
    <div
        class="mx-auto max-w-md w-full bg-bg-surface border border-border ui-card [--card-radius:var(--radius-lg)] [--card-padding:--spacing(1)]">
        <div class="bg-bg shadow p-6 sm:p-8 flex flex-col inner-radius">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div
                    class="size-12 bg-primary text-white text-xl rounded-xl flex items-center justify-center mx-auto mb-4">
                    <span class="iconify ph--speedometer"></span>
                </div>
                <h2 class="text-2xl font-semibold text-fg-title">
                    Confirm your email
                </h2>
                <p class="text-fg-muted mt-1">
                    We sent a 6-digit code to your email address
                </p>
            </div>

            <!-- Login Form -->
            <form class="space-y-4" id="login-form">

                <x-ui.otp class="w-full">
                    <div class="flex items-center gap-2 flex-1">
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                    </div>
                    <span class="flex min-w-max px-3 text-2xl font-semibold text-fg-muted">
                        -
                    </span>
                    <div class="flex items-center gap-2 flex-1">
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                    </div>
                </x-ui.otp>

                <p class="text-sm text-fg-muted">
                    Didn't receive the code?
                    <x-ui.link href="#" underlined class="text-primary">
                        Resend
                    </x-ui.link>
                </p>
                <x-ui.button class="w-full justify-center">
                    Continue
                </x-ui.button>
            </form>

            <!-- Sign Up Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-fg-muted">
                    Don't have an account?
                    <x-ui.link href="#" class="font-medium text-primary ml-1">Sign up</x-ui.link>
                </p>
            </div>
        </div>
    </div>
</main>
