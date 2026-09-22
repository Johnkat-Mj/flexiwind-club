<x-previews.hero-sections.02.navbar/>

<main class="">
    <section>
        <div class="w-full flex items-center relative">
            <div
                class="min-h-max relative mx-auto pt-32 lg:pt-40 px-5 sm:px-10 md:px-12 lg:px-5 lg:max-w-7xl w-full text-center space-y-10">
                <a href="#"
                    class="flex items-center gap-x-2 mx-auto w-max px-2 pr-1 py-1 rounded-ui bg-surface border border-border-strong/40 text-sm text-foreground">
                    Business Operations Made Simple
                    <span class="pr-1">
                        <span class="iconify ph--arrow-right size-3 flex"></span>
                    </span>
                </a>
                <h1
                    class="mx-auto max-w-3xl font-semibold text-title-foreground  text-3xl/tight sm:text-4xl md:text-5xl/tight text-balance">
                    All your business operations in one intuitive dashboard
                </h1>
                <x-ui.text class="mx-auto max-w-xl">
                    Flexify brings together contacts, transactions, analytics, and support in one seamless platform. 
                    Access everything you need from an organized sidebar—no more scattered tools, just clarity and control.
                </x-ui.text>
                <div class="flex flex-col items-center gap-5 w-full mx-auto max-w-md">
                    <x-ui.input.group size="none"
                        class="pl-6 w-full pr-0.5 py-0.5 gap-3 items-center">
                        <x-ui.input variant="unstyled" type="email" name="email" id="email"
                            placeholder="your@email.com" class="w-full flex-1" />
                        <x-ui.button radius-none aria-label="sign up"
                            class="min-w-max rounded-sm relative overflow-hidden duration-300 ease-linear">
                            <span>Get Free Trial</span>
                        </x-ui.button>
                    </x-ui.input.group>
                    <x-ui.text as="span" class="text-center text-sm inline-flex items-center">
                        Dashboard, contacts, transactions, analytics & more <span class="iconify ph--sparkle inline-flex"></span>
                    </x-ui.text>
                </div>
                <div
                    class="mx-auto max-w-6xl w-full aspect-[5/2.3] overflow-hidden bg-gray-50 dark:bg-gray-900/50 ui-card [--card-radius:var(--radius-ui)] [--card-padding:--spacing(3)] rounded-b-none pb-0">
                    <img src="/screen-light.png" alt="Screen Image" width="2000" height="1240" class="w-full h-auto object-cover object-top dark:hidden rounded--txl">
                    <img src="/screen-dark.png" alt="Screen Image" width="2000" height="1240" class="w-full h-auto object-cover object-top not-dark:hidden rounded--txl">
                </div>
            </div>
        </div>
    </section>
</main>