@php
    $painPoints = [
        [
            'icon' => 'ph--timer',
            'title' => 'Stop rebuilding the basics',
            'description' => 'Dashboards, settings, auth, tables, empty states and app shells are ready to adapt.',
        ],
        [
            'icon' => 'ph--paint-brush-broad',
            'title' => 'Ship interfaces that feel expensive',
            'description' => 'Every block is composed with spacing, contrast, states, dark mode and responsive behavior in mind.',
        ],
        [
            'icon' => 'ph--code-block',
            'title' => 'Stay inside Laravel',
            'description' => 'Copy clean Blade, Livewire and Alpine-friendly markup without moving your product into another stack.',
        ],
        [
            'icon' => 'ph--sparkle',
            'title' => 'Customize without fighting the system',
            'description' => 'Clear Blade structure and predictable classes make each block easy to adapt in minutes.',
        ],
    ];
@endphp

<section class="relative border-b border-border-strong/70 border-dashed">
    <div class="mx-auto grid w-full gap-10 px-4 py-20 sm:px-6 lg:max-w-336 lg:grid-cols-[0.8fr_1.2fr] lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div>
            <span class="inline-flex h-7 items-center rounded-ui border border-border bg-surface px-2 text-sm text-muted-foreground">
                Workflow speed
            </span>
            <h2 class="mt-4 max-w-xl text-3xl font-semibold text-title-foreground  sm:text-4xl">
                Your current UI workflow is slower than your backend.
            </h2>
            <p class="mt-4 max-w-md text-sm leading-6 text-muted-foreground">
                Flexiwind Club gives Laravel developers the missing pro UI system: a premium library that feels designed, but still behaves like code you own.
            </p>
        </div>

        <div class="grid gap-px overflow-hidden rounded-ui border border-border bg-border sm:grid-cols-2">
            @foreach ($painPoints as $item)
                <div class="bg-background px-5 py-6">
                    <div class="flex size-9 items-center justify-center rounded-ui bg-primary-50 text-primary dark:bg-primary-950/40">
                        <span class="iconify {{ $item['icon'] }}"></span>
                    </div>
                    <h3 class="mt-5 font-semibold text-title-foreground ">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">{{ $item['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
