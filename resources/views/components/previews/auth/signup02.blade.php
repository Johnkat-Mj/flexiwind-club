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
        <div class="flex-1 mx-auto justify-center items-center max-w-md w-full flex flex-col py-7">
            <div
                class="w-full flex flex-col items-center gap-1 text-center mb-8 pb-4 border-b border-dashed border-border-strong">
                <h1 class="text-2xl font-semibold text-fg-title">
                    Create your account
                </h1>
                <p class="text-fg-muted text-sm text-balance">
                    Fill in your details to get started
                </p>
            </div>
            <form class="flex flex-col w-full space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <x-ui.input type="text" label="First Name" placeholder="John" />
                    <x-ui.input type="text" label="Last Name" placeholder="Doe" />
                </div>
                <x-ui.input type="email" label="Email" placeholder="johndoe@example.com" />
                <div class="space-y-1.5">
                    <x-ui.label for="password">Create Password</x-ui.label>
                    <x-ui.input type="password" id="password" placeholder="••••••••" />
                    <p class="text-xs text-fg-muted mt-1">Use 8 or more characters with a mix of letters, numbers &
                        symbols</p>
                </div>
                <div class="space-y-1.5">
                    <x-ui.label for="confirm-password">Confirm Password</x-ui.label>
                    <x-ui.input type="password" id="confirm-password" placeholder="••••••••" />
                </div>
                <div class="flex pt-4">
                    <x-ui.button type="submit" class="w-full justify-center">
                        Create Account
                    </x-ui.button>
                </div>
                <x-ui.divider label="Or continue with" class="before:bg-bg-muted" label-placement="middle"
                    label-class="px-3 bg-bg text-fg-muted text-sm relative" />

                <div class="flex flex-col space-y-3 mt-1">
                    <x-ui.button variant="outline" intent="gray" class="justify-center gap-2 text-center">
                        <span aria-hidden="true" class="iconify ph--github-logo"></span>
                        Continue with GitHub
                    </x-ui.button>
                    <p class="text-center text-fg-muted text-sm">
                        Already have an account?
                        <x-ui.link href="#" underlined class="text-primary">Login here</x-ui.link>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-bg-muted rounded-l-3xl relative hidden lg:block lg:max-h-dvh lg:sticky lg:top-0">
        <img src="{{ asset('img_2.webp') }}" alt="Auth cover image"
            class="absolute inset-0 h-full w-full object-cover object-top rounded-l-3xl dark:brightness-[0.2] dark:grayscale">
    </div>
</x-ui.auth-split>
