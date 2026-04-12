<x-ui.auth-split as="main" class="min-h-svh">
    <div class="flex flex-col gap-4 p-6 md:p-10">
        <div class="flex justify-center gap-2 lg:justify-start">
            <a href="#" class="flex items-center gap-2 font-medium">
                <div class="bg-primary text-white size-9 d-flex-place-center rounded-ui">
                    <span class="iconify ph--speedometer"></span>
                </div>
                <span>
                    Acme Inc.
                </span>
            </a>
        </div>
        <div class="flex-1 mx-auto justify-center items-center max-w-sm w-full flex flex-col">
            <div
                class="w-full flex flex-col items-center gap-1 text-center mb-8 pb-4 border-b border-dashed border-border-strong">
                <h1 class="text-2xl font-semibold text-fg-title">
                    Login to your account
                </h1>
                <p class="text-fg-muted text-sm text-balance">
                    Enter your email below to login to your account
                </p>
            </div>
            <form class="flex flex-col space-y-4 w-full">
                <x-ui.input type="email" label="Email" placeholder="johndoe@gmail.com" />
                <div class="flex flex-col space-y-1.5">
                    <div class="flex justify-between items-center">
                        <x-ui.label for="password"> Password</x-ui.label>
                        <x-ui.link href="#" underlined class="text-primary text-sm">
                            Forgot your password?
                        </x-ui.link>
                    </div>
                    <x-ui.input type="password" id="password" />
                </div>
                <div class="flex pt-4">
                    <x-ui.button type="submit" class="w-full justify-center">
                        Login
                    </x-ui.button>
                </div>
                <x-ui.divider label="Or continue with" class="before:bg-bg-muted" label-placement="middle"
                    label-class="px-3 bg-bg text-fg-muted text-sm relative" />

                <div class="flex flex-col space-y-3 mt-1">
                    <x-ui.button variant="outline" intent="gray" class="justify-center text-center">
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
                       Continue with Google
                    </x-ui.button>
                    <p class="text-center text-fg-muted text-sm">
                        Don't have an account?
                        <x-ui.link href="#" underlined class="text-primary">Sign up</x-ui.link>
                    </p>
                </div>
            </form>
        </div>
        <div class="flex justify-center text-center text-fg-muted">
            <span class="text-sm">Uno Forge &copy; {{ date('Y') }} </span>
        </div>
    </div>
    <div class="bg-bg-muted rounded-l-3xl relative hidden lg:block lg:max-h-dvh lg:sticky lg:top-0">
        <img src="{{ asset('img_2.webp') }}" alt="Auth cover image"
            class="absolute inset-0 h-full w-full object-cover object-top rounded-l-3xl dark:brightness-[0.2] dark:grayscale">
    </div>
</x-ui.auth-split>
