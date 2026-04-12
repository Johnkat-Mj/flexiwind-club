<main class="min-h-screen d-flex-place-center px-5 sm:px-10 lg:px-0 py-6">
    <form action=""
        class="border border-border-strong/40 w-full max-w-md p-1 shadow-md shadow-gray-200/40 dark:shadow-transparent bg-bg rounded-ui">
        <div class="p-5 sm:p-8">
            <div
                class="size-12 bg-primary text-white text-xl rounded-xl flex items-center justify-center mx-auto mb-4">
                <span class="iconify ph--speedometer"></span>
            </div>
            <div class="text-center">
                <h1 class="text-fg-title mb-1 text-xl font-semibold">Welcome back</h1>
                <p class="text-sm text-fg-muted">
                    Sign in to your account
                </p>
            </div>
            <x-ui.divider class="my-8 border-border-strong/60" />
            <div class="flex flex-col gap-4">
                <x-ui.input type="email" placeholder="johndoe@gmail.com" label="Email" />
                <x-ui.input type="password" placeholder="************" label="Password" />
                <div class="flex justify-between w-full pt-3">
                    <x-ui.checkbox id="remember_me" label="Remember me" />
                    <x-ui.link href="#" class="inline text-primary hover:text-primary text-sm">Forgot
                        password
                        ?</x-ui.link>
                </div>
                <x-ui.button class="justify-center w-full mt-6">
                    Sign in
                </x-ui.button>
            </div>
        </div>
        <div class="bg-bg-muted/60 text-fg rounded px-5 sm:px-6 py-4">
            <p class="text-center text-sm">
                Having trouble signing in?
                <x-ui.link href="#" class="inline text-primary hover:text-primary-700 font-medium">Contact
                    us</x-ui.link>
            </p>
        </div>
    </form>
</main>
