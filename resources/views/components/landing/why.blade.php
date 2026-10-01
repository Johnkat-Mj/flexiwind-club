{{-- « Why Flexiwind » : quatre démos vivantes, chacune un argument. --}}
@php
    $card = 'flex flex-col overflow-hidden rounded-[22px] border border-border bg-background shadow-xs';
    $stage = 'bg-dots relative shrink-0 overflow-hidden border-b border-border bg-surface';
@endphp

<x-site.section>
    <x-site.container no-padding class="py-20 lg:py-28">
        <x-site.section-heading icon="ph--sparkle" eyebrow="Why Flexiwind" title="Ship screens," muted="not boilerplate."
            class="px-4 sm:px-6 lg:px-10 xl:px-12">
            Everything below is live — click it. The same pieces land in your repo as plain Blade the moment you run the
            command.
        </x-site.section-heading>

        <div
            class="mt-14 w-full border-t border-border relative px-4 sm:px-6 lg:px-10 xl:px-12">
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-1.5 z-10 px-2 lg:px-0">
                <div class="relative mx-auto h-2.75 w-full max-w-300">
                    <x-site.cross class="-left-1.25" />
                    <x-site.cross class="-right-1.25" />
                </div>
            </div>
            <span class="h-30 absolute inset-y-0 left-0 w-4 sm:w-6 lg:w-10 xl:w-12"></span>

            <span class="h-30 absolute inset-y-0 right-0 sm:w-6 lg:w-10 xl:w-12"></span>
            <div>

            </div>
        </div>
    </x-site.container>
</x-site.section>
