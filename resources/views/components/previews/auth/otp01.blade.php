<main class="d-flex-place-center w-full h-max min-h-screen px-6 py-12 ">
    <div
        class="max-w-md w-full block bg-bg ring ring-border-card ui-card [--card-radius:var(--radius-ui)] [--card-padding:--spacing(1)] relative h-fit shadow-xl shadow-gray-950/10">
        <div class="p-10">
            <div>
                <h1 class="block text-fg-title text-xl font-semibold mb-1">
                    Confirm your email
                </h1>
                <p class="text-fg-muted text-sm font-normal my-0">
                     We sent a 6-digit code to your email address
                </p>
            </div>
            <form class="mx-auto mt-8 space-y-6">
                <x-ui.otp class="w-full">
                    <div class="flex items-center gap-2 flex-1">
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
                        <x-ui.otp.input size="none" class="size-10 flex-1" />
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
        </div>
        <div class="block p-4 bg-bg-muted/40 inner-radius">
            <p class="text-fg-muted text-sm font-normal text-center">
                By clicking continue, you agree to our
                <x-ui.link href="#" underlined class="text-primary">Terms of Service</x-ui.link>
                and <x-ui.link href="#" underlined class="text-primary">Privacy Policy</x-ui.link>.
            </p>
        </div>
    </div>
</main>
