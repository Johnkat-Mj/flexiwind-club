@php
    $templates = config('templates');
@endphp

<x-layouts::site>
    <main x-data="{ tier: 'all' }">
        <x-site.page-header icon="ph--layout" eyebrow="Templates" title="Start from a whole app." muted="Not a blank page.">
            Complete Laravel applications built with the same Flexiwind components — explore them live, then make them yours.
            <x-slot:actions>
                <div role="tablist" aria-label="Price" class="flex gap-0.5 rounded-[10px] bg-subtle p-0.75">
                    @foreach (['all' => 'All', 'free' => 'Free', 'paid' => 'Paid'] as $key => $label)
                        <button type="button" role="tab" x-on:click="tier = '{{ $key }}'" x-bind:aria-selected="tier === '{{ $key }}'"
                            x-bind:class="tier === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                    @endforeach
                </div>
            </x-slot:actions>
        </x-site.page-header>

        <x-site.section>
            <x-site.container class="flex flex-col gap-6 pt-10 pb-16">
                @foreach ($templates as $template)
                    <x-site.template-card :template="$template" x-show="tier === 'all' || tier === '{{ $template['tier'] }}'" />
                @endforeach
            </x-site.container>
        </x-site.section>

        <x-site.section>
            <x-site.container class="py-10">
                <x-site.request-banner title="Need another kind of app?" text="Tell us what you are building — requests decide the next template."
                    action="Request a template" />
            </x-site.container>
        </x-site.section>
    </main>
</x-layouts::site>
