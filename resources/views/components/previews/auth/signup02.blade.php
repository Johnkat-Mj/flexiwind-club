<main class="d-flex-place-center w-full h-max min-h-screen px-6 py-12">
    <div
        class="max-w-lg w-full block bg-bg ring ring-border-card ui-card [--card-radius:var(--radius-ui)] [--card-padding:--spacing(1)] relative h-fit shadow-xl shadow-gray-950/10">
        <div class="p-10">
            <div>
                <h1 class="block text-fg-title text-xl font-semibold mb-1">
                    Signin to Flexify
                </h1>
                <p class="text-fg-muted text-sm font-normal my-0">
                    Welcome back! Sign in to continue
                </p>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <x-ui.button size="sm" variant="outline" class="md:h-9 w-full justify-center ">
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
                <x-ui.button size="sm" variant="outline" class="md:h-9 w-full justify-center ">
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
            <x-ui.divider label-placement="middle" label="Or register with" class="before:bg-bg-muted mt-6"
                label-class="px-3 bg-bg text-fg-muted text-sm relative" />
            <form class="mx-auto mt-8 space-y-6">
               <div class="grid grid-cols-2 gap-4">
                    <x-ui.input type="text" placeholder="John" label="First Name" />
                    <x-ui.input type="text" placeholder="Doe" label="Last Name" />
                </div>
                <x-ui.input type="email" placeholder="johndoe@example.com" label="Email" />
                <x-ui.input type="password" placeholder="••••••••" label="Create Password" />
                <x-ui.input type="password" placeholder="••••••••" label="Confirm Password" />
                <div class="text-xs text-fg-muted -mt-2">
                    Use 8 or more characters with a mix of letters, numbers & symbols
                </div>
                <x-ui.button size="sm" class="w-full justify-center md:h-9">
                    <span>Register</span>
                </x-ui.button>
            </form>
        </div>
        <div class="block p-4 bg-bg-muted/40 inner-radius">
            <p class="text-fg-muted text-sm font-normal text-center">
                Already have an account ?
                <x-ui.link href="#"
                    class="inline text-primary hover:text-primary-700 dark:hover:text-primary-400 font-medium">
                    Login
                </x-ui.link>
            </p>
        </div>
    </div>
</main>
