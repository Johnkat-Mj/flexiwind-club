@php
    $faqs = [
        ['question' => 'Is Flexiwind Club only for Livewire?', 'answer' => 'No. The blocks are built for Laravel Blade first, and the interactive pieces are friendly to Livewire and Alpine.'],
        ['question' => 'Do I need a design system already?', 'answer' => 'No. Flexiwind Club gives you polished blocks, modern templates and component patterns you can adapt to your brand.'],
        ['question' => 'Can I use it for client work?', 'answer' => 'Yes. It is designed for production projects, prototypes and client dashboards where you need to move fast.'],
        ['question' => 'What makes it different from free Flexiwind?', 'answer' => 'The club focuses on deeper app patterns, premium sections, complete screens, richer states and more guidance.'],
    ];
@endphp

<section class="border-b border-border-strong/70 border-dashed">
    <div class="mx-auto grid w-full gap-10 px-4 py-20 sm:px-6 lg:max-w-336 lg:grid-cols-[0.8fr_1.2fr] lg:px-8 lg:py-28 xl:max-w-352 xl:px-8">
        <div>
            <span class="inline-flex h-7 items-center rounded-ui border border-border bg-surface px-2 text-sm text-muted-foreground">
                FAQ
            </span>
            <h2 class="mt-4 text-3xl font-semibold text-title-foreground  sm:text-4xl">
                Questions you might have.
            </h2>
        </div>

        <x-ui.accordion class="overflow-hidden rounded-ui border border-border bg-surface" default-value="faq-1">
            @foreach ($faqs as $item)
                <x-ui.accordion.item :id="'faq-' . ($loop->index + 1)" variant="default" class="px-5 last:border-b-0">
                    <x-ui.accordion.trigger class="py-4 text-left text-sm font-medium text-title-foreground ">
                        {{ $item['question'] }}
                        <x-ui.accordion.indicator type="plus-sign" />
                    </x-ui.accordion.trigger>
                    <x-ui.accordion.content>
                        <p class="pb-5 text-sm leading-6 text-muted-foreground">{{ $item['answer'] }}</p>
                    </x-ui.accordion.content>
                </x-ui.accordion.item>
            @endforeach
        </x-ui.accordion>
    </div>
</section>
