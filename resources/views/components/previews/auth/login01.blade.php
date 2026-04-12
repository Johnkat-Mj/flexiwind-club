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
                <h2 class="text-2xl font-semibold text-fg-title">Welcome back</h2>
                <p class="text-fg-muted mt-1">Sign in to your account</p>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-3">
                <x-ui.button size="sm" variant="outline" class="w-full md:h-9 justify-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="0.98em" height="1em" viewBox="0 0 256 262"
                        class="mr-2 size-3.5">
                        <path fill="#4285f4"
                            d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622l38.755 30.023l2.685.268c24.659-22.774 38.875-56.282 38.875-96.027">
                        </path>
                        <path fill="#34a853"
                            d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055c-34.523 0-63.824-22.773-74.269-54.25l-1.531.13l-40.298 31.187l-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1">
                        </path>
                        <path fill="#fbbc05"
                            d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82c0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602z">
                        </path>
                        <path fill="#eb4335"
                            d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0C79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251">
                        </path>
                    </svg>
                    <span>Google</span>
                </x-ui.button>
                <x-ui.button size="sm" variant="outline" class="w-full md:h-9 justify-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"
                        class="mr-2 size-3.5">
                        <path fill="#f1511b" d="M121.666 121.666H0V0h121.666z"></path>
                        <path fill="#80cc28" d="M256 121.666H134.335V0H256z"></path>
                        <path fill="#00adef" d="M121.663 256.002H0V134.336h121.663z"></path>
                        <path fill="#fbbc09" d="M256 256.002H134.335V134.336H256z"></path>
                    </svg>
                    <span>Microsoft</span>
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
                        <x-ui.input id="login-password" variant="unstyled" type="email" placeholder="Your email here"
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
