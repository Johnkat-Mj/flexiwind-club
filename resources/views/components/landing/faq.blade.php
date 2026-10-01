@php
    $questions = [
        ['Is Flexiwind a Composer package?', 'No. The CLI copies each component or block into your project as plain Blade files. There is no runtime dependency to update — the code is yours to change.'],
        ['Do I need Livewire?', 'No. The blocks are built for Laravel Blade first, and the interactive pieces are friendly to Livewire and Alpine.'],
        ['What stays free?', 'Every UI primitive, the free blocks, the CLI and the full documentation. Pro examples stay visible in the docs — only their source is reserved.'],
        ['How do Pro tokens work?', "Generate a token from your account and put it in .env. Tokens don't expire: access follows your subscription and stops the moment it ends or your seat is freed."],
        ['Can my team share one plan?', 'Team Lifetime covers five people. Each one signs in with their own email and manages their own tokens; the owner can reassign a seat at any time.'],
    ];
@endphp

<x-site.section>
    <x-site.container class="grid gap-10 py-20 lg:grid-cols-[380px_minmax(0,1fr)] lg:gap-16 lg:py-28">
        <div>
            <x-site.section-heading icon="ph--question" eyebrow="FAQ" title="Questions," muted="answered." :center="false">
                Something missing? Open an issue on
                <a href="https://github.com/unoforge/flexiwind/issues" class="font-medium text-title-foreground underline underline-offset-3">GitHub</a>.
            </x-site.section-heading>
        </div>
        <x-ui.accordion default-value="faq-0" class="flex flex-col border-t border-border">
            @foreach ($questions as $index => [$question, $answer])
                <x-ui.accordion.item id="faq-{{ $index }}">
                    <x-ui.accordion.trigger class="group cursor-pointer gap-4 py-5 text-left text-base font-medium text-title-foreground">
                        {{ $question }}
                        <span class="flex size-7.5 shrink-0 items-center justify-center rounded-full border border-border transition-colors in-aria-expanded:border-transparent in-aria-expanded:bg-gray-900 in-aria-expanded:text-white dark:in-aria-expanded:bg-white dark:in-aria-expanded:text-gray-950">
                            <x-ui.accordion.indicator type="plus-sign" class="text-current" />
                        </span>
                    </x-ui.accordion.trigger>
                    <x-ui.accordion.content>
                        <p class="max-w-160 pb-5 text-[15px]/relaxed text-muted-foreground">{{ $answer }}</p>
                    </x-ui.accordion.content>
                </x-ui.accordion.item>
            @endforeach
        </x-ui.accordion>
    </x-site.container>
</x-site.section>
