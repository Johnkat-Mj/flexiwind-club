<main class="flex min-h-screen justify-center items-center px-4 sm:px-10 lg:px-0">
    <div
        class="mx-auto max-w-md w-full bg-bg-surface border border-border ui-card [--card-radius:var(--radius-lg)] [--card-padding:--spacing(1)]">
        <div class="bg-bg shadow p-6 sm:p-8 flex flex-col inner-radius">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div
                    class="size-12 bg-primary text-white text-xl rounded-xl flex items-center justify-center mx-auto mb-4">
                    <span class="iconify ph--speedometer"></span>
                </div>
                <h2 class="text-2xl font-semibold text-fg-title">Welcome back</h2>
                <p class="text-fg-muted mt-1">Sign in to your account</p>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-3">
                <x-ui.button variant="outline" intent="gray" size="sm" class="justify-center">
                    <span class="iconify ph--google-logo mr-2"></span>
                    <span>Google</span>
                </x-ui.button>
                <x-ui.button variant="outline" intent="gray" size="sm" class="justify-center">
                    <span class="iconify ph--github-logo mr-2"></span>
                    <span>GitHub</span>
                </x-ui.button>
            </div>

            <x-ui.divider label-placement="middle" label="Or continue with" class="before:bg-bg-muted my-6"
                label-class="pr-3 bg-bg text-fg relative" />

            <!-- Login Form -->
            <form class="space-y-4" id="login-form">
                <x-ui.input type="email" id="login-email" label="Email" placeholder="you@company.com" />

                <div class="space-y-2">
                    <x-ui.label for="login-password" class="block">Password</x-ui.label>
                    <x-ui.input.group>
                        <x-ui.input id="login-password" un-styled type="email" placeholder="Your email here"
                            class="pe-11 px-3" />
                        <x-ui.input.trailing absolute class="text-fg" clickable>
                            <button type="button" class="flex items-center cursor-pointer">
                                <span class="iconify ph--eye text-fg-muted/80"></span>
                            </button>
                        </x-ui.input.trailing>
                    </x-ui.input.group>
                </div>

                <div class="flex items-center justify-between">
                    <x-ui.checkbox id="remember_me" label="Remember me" />
                    <x-ui.link href="#" class="text-sm text-primary">Forgot password?</x-ui.link>
                </div>

                <x-ui.button type="submit" class="w-full justify-center">
                    Sign in
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
