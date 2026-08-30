<section class="py-20 lg:py-32">
    <div class="px-5 sm:px-10 md:px-12 lg:px-5 lg:max-w-7xl mx-auto w-full">
        <x-ui.badge variant="soft" intent="primary" size="sm" class="flex mx-auto w-max text-center relative text-primary">
            Features
        </x-ui.badge>
        <h1
            class="mt-5 text-3xl md:text-4xl xl:text-5xl mx-auto text-center md:max-w-2xl text-title-foreground  font-semibold leading-tight">
            Keep your business on growing
        </h1>
        <x-ui.text class="max-w-lg mt-6 text-center mx-auto">
            Manage leads, automate workflows, and close more deals faster —
            everything you need to grow your business in one place.
        </x-ui.text>
        <div class="grid gap-14 md:grid-cols-2 lg:grid-cols-4 mt-16">
            <div class="order-1 grid gap-10 sm:grid-cols-2 md:order-1 md:grid-cols-1 lg:order-1">
                <x-previews.features.01.feature-card icon="ph--chart-pie" title="Real-time Dashboard"
                    description=" Monitor your business performance with live metrics, KPIs, and visual analytics that update in real-time." />
                <x-previews.features.01.feature-card icon="ph--bell" title="Smart Notifications"
                    description="Stay informed with intelligent alerts and notifications that keep you updated on important business events." />
            </div>
            <div
                class="flex order-3 md:col-span-2 lg:order-2">
                <div
                    class="flex-1 flex relative bg-linear-to-tr from-muted to-bg-surface rounded-ui aspect-[4/2.4] overflow-hidden ring ring-border">
                    <img src="/images/dash-dark.webp" alt="illustration dark" width="1800" class="absolute w-auto  h-full left-5 top-4 hidden dark:block rounded-tl-ui">
                    <img src="/images/dash-light.webp" alt="illustration light" width="1800" class="absolute w-auto h-full left-5 top-4 dark:hidden rounded-ui">
                </div>
            </div>
            <div class="order-1 grid gap-10 sm:grid-cols-2 md:order-2 md:grid-cols-1 lg:order-3">
                <x-previews.features.01.feature-card icon="ph--lock" title="Advanced Security"
                    description="Protect your data with enterprise-grade security, two-factor authentication, and role-based access controls." />
                <x-previews.features.01.feature-card icon="ph--cloud-arrow-up" title="Cloud Sync"
                    description="Access your data anywhere with automatic cloud synchronization and real-time backup across all devices." />
            </div>
        </div>
    </div>
</section>
