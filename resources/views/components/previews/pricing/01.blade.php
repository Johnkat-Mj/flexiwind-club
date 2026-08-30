<section class="py-32">
    <div class="px-5 sm:px-10 md:px-12 lg:px-5 lg:max-w-7xl mx-auto w-full flex flex-col space-y-16">
        <div class="flex gap-14 md:justify-between flex-col md:flex-row items-center">
            <div class="text-center md:text-left md:max-w-lg space-y-5">
                <span
                    class="ui-subtle ui-subtle-gray text-xs px2.5 py1 font-semibold tracking-wide rounded-xl">Plans</span>
                <h2 class="font-semibold leading-tight text-title-foreground  text-3xl md:text-4xl xl:text-5xl">
                    Choose the right plan for your team
                </h2>
                <p class="text-foreground pt-2">
                    Flexible pricing for developers, startups, and enterprises. Scale as you grow.
                </p>
            </div>
            <div class="min-w-max flex justify-center md:justify-end">
                <div
                    class="rounded-xl bg-background shadow-lg shadow-gray-200/40 dark:shadow-none flex items-center relative p-1">
                    <button data-state="active"
                        class="btn btn-md w-max rounded-lg text-foreground bg-transparent fx-active:text-white fx-active:bg-primary">
                        Monthly
                    </button>
                    <button data-state="inactive"
                        class="btn btn-md w-max rounded-lg text-foreground bg-transparent fx-active:text-white fx-active:bg-primary">
                        Yearly
                    </button>
                </div>
            </div>
        </div>
        <div
            class="grid divide-y divide-border lg:divide-y-0 gap-6 mx-auto lg:items-stretch lg:grid-cols-3 md:gap-8 lg:gap-12 bg-background border border-border rounded-xl px-4 md:px-6 lg:px-8 pb-10">
            <!-- Free Plan -->
            <div class="bg-background pt-6 px-4 h-auto flex flex-col">
                <div class="min-h-max mb-5">
                    <div class="relative flex items-end">
                        <div class="flex">
                            <span class="text-4xl font-bold text-title-foreground ">$0</span>
                        </div>
                        <span class="text-foreground">/month</span>
                    </div>
                    <h2 class="text-xl font-semibold text-subtitle pt-5">
                        Free
                    </h2>
                    <p class="text-foreground pt-2">
                        Perfect for individuals and hobby projects. Get started with core features.
                    </p>
                </div>
                <ul role="list" class="flex flex-col gap-2 text-foreground">
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Unlimited public repositories
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Community support
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Basic CI/CD pipelines
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        1 concurrent build
                    </li>
                </ul>
                <div class="mt-5 flex flex-1 items-end min-h-max">
                    <a href="#"
                        class="relative w-full btn btn-lg justify-center before:absolute before:inset-0 before:rounded-lg before:btn-outline before:btn-outline-gray before:transition before:duration-300 active-before:scale-95 rounded-md">
                        <span class="relative text-sm font-medium text-muted-foreground">Continue for free</span>
                    </a>
                </div>
            </div>

            <!-- Team Plan -->
            <div class="bg-background pt-6 px-4 h-auto flex flex-col">
                <div class="min-h-max mb-5">
                    <div class="relative flex items-end">
                        <div class="flex">
                            <span class="text-4xl font-bold text-title-foreground ">$20</span>
                        </div>
                        <span class="text-foreground">/month</span>
                    </div>
                    <h2 class="text-xl font-semibold text-subtitle pt-5">
                        Team
                    </h2>
                    <p class="text-foreground pt-2">
                        For small teams and startups. Collaborate and ship faster with advanced features.
                    </p>
                </div>
                <ul role="list" class="flex flex-col gap-2 text-foreground">
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Unlimited private repositories
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Priority email support
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Advanced CI/CD pipelines
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        5 concurrent builds
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Team management & permissions
                    </li>
                    <li class="flex gap-4 items-center">
                        <span class="bg-surface text-sm text-foreground px-2 py-1 rounded-full">&check;</span>
                        Integrations (Slack, GitHub, etc.)
                    </li>
                </ul>
                <div class="mt-5 flex flex-1 items-end min-h-max">
                    <a href="#"
                        class="relative w-full btn btn-lg justify-center before:absolute before:inset-0 before:rounded-lg before:btn-outline before:btn-outline-gray before:transition before:duration-300 active-before:scale-95 rounded-md">
                        <span class="relative text-sm font-medium text-muted-foreground">Get started</span>
                    </a>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div
                class="relative pt-6 px-4 mt-6 lg:mt-0 h-auto flex flex-col before:absolute before:z-0 before:scale-x-[1.13] sm:before:scale-x-[1.15] lg:before:scale-x-105 before:scale-y-105 lg:before:scale-y-110 before:inset-0 before:bg-gray-950 before:border before:border-border-strong before:rounded-xl">
                <div
                    class="absolute top-0 right-0 z-5 bg-gray-500/40 dark:bg-primary-900 text-white rounded-xl px-4 py-1">
                    Most Popular
                </div>
                <div class="min-h-max pb-5 relative z-10">
                    <div class="relative flex items-end">
                        <div class="flex">
                            <span class="text-4xl md:text-5xl font-bold text-white">$99</span>
                        </div>
                        <span class="text-xl font-semibold text-gray20">/month</span>
                    </div>
                    <h2 class="text-xl font-semibold text-white pt-5">
                        Enterprise
                    </h2>
                    <p class="text-gray-300 pt-2">
                        For growing businesses and enterprises. Get premium support and advanced security.
                    </p>
                </div>
                <ul role="list" class="flex flex-col h-full gap-2 text-gray-300 relative">
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>All Team features</span>
                    </li>
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>Premium support (24/7)</span>
                    </li>
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>Single Sign-On (SSO)</span>
                    </li>
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>Audit logs & compliance</span>
                    </li>
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>Custom integrations</span>
                    </li>
                    <li class="inline-flex gap-4 items-center">
                        <span class="bg-gray-500/40 text-sm text-gray-300 px-2 py-1 rounded-full">&check;</span>
                        <span>99.9% uptime SLA</span>
                    </li>
                </ul>
                <div class="pt4 flex min-h-max">
                    <a href="#"
                        class="relative w-full btn btn-lg justify-center before:absolute before:inset-0 before:rounded-lg before:btn-solid before:btn-solid-primary before:transition before:duration-300 active-before:scale-95">
                        <span class="relative text-sm font-medium text-white">Contact sales</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>