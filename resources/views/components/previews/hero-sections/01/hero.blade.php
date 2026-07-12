<x-previews.hero-sections.01.navbar />


<section class="pt-10 relative">
    <div
        class="absolute bottom-0 left-0 right-0 top-0 ui-grid [--unify-ui-grid-width:24px] [--unify-ui-grid-height:24px] ui-striped-overlay-mask text-fg-muted/10">
    </div>
    <div class="w-full flex items-center relative">
        <div class="min-h-max px-5 sm:px-10 md:px-12 lg:px-5 relative mx-auto pt-32 lg:max-w-7xl w-full text-center">
            <a href="#"
                class="flex items-center gap-x-2 mx-auto w-max px-2 pr-1 py-1 rounded-xl text-sm ui-subtle ui-subtle-gray">
                <span class="iconify size-3 ph--sparkle "></span>
                AI Mode avaible
                <span class="px-1.5 py-1 rounded-lg bg-bg-muted">
                    <x-ui.icon name="ph--arrow-right" size="xs"/>
                </span>
            </a>
            <h1
                class="mt-5 text-transparent bg-clip-text bg-linear-to-br from-fg-title to-fg/50 text-4xl/tight sm:text-5xl/tight md:text-6xl/tight mx-auto max-w-3xl font-bold">
                Manage your leads, easier than ever before
            </h1>
            <x-ui.text class="mx-auto max-w-md mt-6">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt saepe atque enim quasi
            </x-ui.text>
            <x-ui.input.group size="none"
                class="flex gap-3 items-center ease-linear pr-1 w-full mx-auto max-w-xs mt-6.5">
                <x-ui.input variant="unstyled" type="email" name="" id=""
                    placeholder="johndoe@gmail.com" class="w-full bg-transparent outline-none py-2 px-4"
                    autocomplete="off" />
                <x-ui.button aria-label="sign up" size="sm" :radius="false" class="min-w-max rounded-md">
                    <span class="hidden sm:flex relative z5">
                        Subscribe
                    </span>
                    <span class="flex sm:hidden relative z5">
                        <span class="iconify ph--paper-plane-tilt size-5"></span>
                    </span>
                </x-ui.button>
            </x-ui.input.group>

            <div class="flex items-center gap-1 gap-x-2 justify-center mx-auto mt-5">
                <div class="flex items-center -space-x-1  *:ring-2 *:ring-border">
                    <x-ui.avatar src="/avatar1.webp" width="2250" alt="listener avatar" class="bg-bg-muted" />
                    <x-ui.avatar src="/avatar2.webp" width="2250" alt="listener avatar" class="bg-bg-muted" />
                    <x-ui.avatar src="/avatar1.webp" width="2250" alt="listener avatar" class="bg-bg-muted" />
                </div>
                <div class="flex flex-col justify-start items-start -space-y-1">
                    <div class="">
                        <span class="text-xs text-orange-600">
                            &starf; &starf; &starf; &starf; &starf;
                        </span>
                    </div>
                    <x-ui.text as="span" class="text-sm">
                        +400 Lovely users
                    </x-ui.text>
                </div>
            </div>

            <div
                class="mx-auto max-w-4xl ui-card [--card-radius:var(--radius-xl)] [--card-padding:--spacing(1)] aspect-auto overflow-hidden bg-linear-to-t from-bg-subtle to-bg-muted mt-14">
                <img src="/images/dash-light.webp" width="1440" height="1024" alt="product image"
                    class="inner-radius w-full h-auto dark:hidden">
                <img src="/images/dash-dark.webp" width="1440" height="1024" alt="product image"
                    class="inner-radius w-full h-auto hidden dark:flex">
            </div>
        </div>
    </div>
</section>
