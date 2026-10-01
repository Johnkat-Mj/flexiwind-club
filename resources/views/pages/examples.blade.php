@php
    // Chaque exemple est un vrai composant du cookbook, rendu tel quel.
    $examples = [
        ['key' => 'confirmation-dialog', 'title' => 'Confirmation dialog', 'category' => 'modals', 'description' => 'Use confirmation dialogs for destructive actions without making the UI heavy.', 'requires' => ['modal', 'button']],
        ['key' => 'modal-form-basic', 'title' => 'Modal form', 'category' => 'modals', 'description' => 'Build modal forms that validate cleanly, submit safely, and keep actions obvious.', 'requires' => ['modal', 'label', 'input', 'button']],
        ['key' => 'modal-form-livewire', 'title' => 'Livewire modal form', 'category' => 'modals', 'description' => 'A Livewire-friendly structure with validation, loading state, and clear actions.', 'requires' => ['modal', 'label', 'input', 'textarea', 'button']],
        ['key' => 'modal-form-alpine', 'title' => 'Alpine modal form', 'category' => 'modals', 'description' => 'Alpine works well for small local UI state that does not need the server.', 'requires' => ['label', 'input', 'textarea', 'button']],
        ['key' => 'form-field', 'title' => 'Form field', 'category' => 'forms', 'description' => 'Small form snippets and conventions you can reuse across app screens.', 'requires' => ['label', 'input']],
        ['key' => 'form-actions', 'title' => 'Form actions', 'category' => 'forms', 'description' => 'Keep actions predictable and comfortable on mobile and desktop.', 'requires' => ['button']],
    ];
    foreach ($examples as $index => $example) {
        // Le fichier que Blade rend : celui du site s'il existe, sinon celui du registre.
        $examples[$index]['source'] = file_get_contents(view()->getFinder()->find("components.examples.cookbook.{$example['key']}"));
        $examples[$index]['command'] = 'php artisan flexi:add '.implode(' ', $example['requires']);
        $examples[$index]['prompt'] = "Using the Flexiwind components already in this project ({$examples[$index]['command']}), build a \"{$example['title']}\": {$example['description']} Reuse x-ui components only, no new CSS.";
    }
@endphp

<x-layouts::site>
    <main x-data="{ category: 'all', current: null }">
        <x-site.page-header icon="ph--stack" eyebrow="Examples" title="Advanced compositions." muted="Copy the pattern.">
            Real patterns built from Flexiwind components: modals that validate, destructive confirmations and form conventions.
            Open the code, or hand the prompt to your agent.
            <x-slot:actions>
                <div role="tablist" aria-label="Filter" class="flex gap-0.5 rounded-[10px] bg-subtle p-0.75">
                    @foreach (['all' => 'All', 'modals' => 'Modals', 'forms' => 'Forms'] as $key => $label)
                        <button type="button" role="tab" x-on:click="category = '{{ $key }}'" x-bind:aria-selected="category === '{{ $key }}'"
                            x-bind:class="category === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                    @endforeach
                </div>
            </x-slot:actions>
        </x-site.page-header>

        <x-site.section>
            <x-site.container class="grid gap-6 pt-9 pb-16 lg:grid-cols-2">
                @foreach ($examples as $index => $example)
                    <article x-show="category === 'all' || category === '{{ $example['category'] }}'"
                        class="flex flex-col overflow-hidden rounded-[18px] border border-border bg-background shadow-xs">
                        {{-- Le formulaire ne part nulle part : c'est une démo. --}}
                        <div x-on:submit.prevent class="bg-dots relative flex h-85 items-center justify-center border-b border-border bg-surface p-6">
                            <x-dynamic-component :component="'examples.cookbook.'.$example['key']" />
                        </div>
                        <div class="flex items-center justify-between gap-4 py-4 pr-4 pl-5">
                            <span class="flex min-w-0 flex-col gap-0.75">
                                <span class="text-[15.5px] font-semibold text-title-foreground">{{ $example['title'] }}</span>
                                <span class="text-[13.5px]/5 text-muted-foreground">{{ $example['description'] }}</span>
                            </span>
                            <x-ui.slideover.trigger slide-over-id="example-code" x-on:click="current = {{ $index }}" variant="outline" intent="gray"
                                class="h-9 shrink-0 gap-1.75 rounded-[10px] px-3.5 text-[13.5px] font-medium text-title-foreground">
                                <span aria-hidden="true" class="iconify ph--code"></span>Code
                            </x-ui.slideover.trigger>
                        </div>
                    </article>
                @endforeach
            </x-site.container>
        </x-site.section>

        <x-site.section>
            <x-site.container class="py-10">
                <x-site.request-banner title="Looking for a pattern?" text="Tell us which composition you keep rebuilding — we'll write it up."
                    action="Suggest an example" />
            </x-site.container>
        </x-site.section>

        {{-- Code de l'exemple ouvert --}}
        <x-ui.slideover id="example-code" size="3xl" :closable="false">
            <x-ui.slideover.content class="bg-background">
                @foreach ($examples as $index => $example)
                    <div x-show="current === {{ $index }}" x-cloak class="flex h-full flex-col">
                        <div class="flex flex-col gap-4 border-b border-border px-6 pt-5.5 pb-4.5">
                            <div class="flex items-start justify-between gap-4">
                                <span class="flex flex-col gap-1.5">
                                    <span class="font-display text-2xl font-semibold tracking-[-0.02em] text-title-foreground">{{ $example['title'] }}</span>
                                    <span class="text-[15px]/6 text-muted-foreground">{{ $example['description'] }}</span>
                                </span>
                                <x-ui.slideover.close variant="outline" intent="gray" icon-only aria-label="Close" class="size-8.5 shrink-0 rounded-[9px] text-title-foreground">
                                    <span aria-hidden="true" class="iconify ph--x"></span>
                                </x-ui.slideover.close>
                            </div>
                            <span class="text-[13px] font-semibold text-title-foreground">AI prompt &amp; CLI</span>
                            <div class="flex gap-2">
                                <button type="button" x-data="copyText(@js($example['prompt']))" x-on:click="copy()"
                                    class="flex h-10 shrink-0 cursor-pointer items-center gap-2 rounded-[10px] border border-border px-3.5 text-[13.5px] font-medium text-title-foreground hover:bg-surface">
                                    <span aria-hidden="true" class="iconify ph--robot" x-show="!copied"></span>
                                    <span aria-hidden="true" class="iconify ph--check text-success" x-show="copied" x-cloak></span>
                                    <span x-text="copied ? 'Copied' : 'Copy prompt'">Copy prompt</span>
                                </button>
                                <button type="button" x-data="copyText(@js($example['command']))" x-on:click="copy()" aria-label="Copy install command"
                                    class="flex h-10 min-w-0 flex-1 cursor-pointer items-center gap-2.5 rounded-[10px] border border-border pr-3 pl-1.5 hover:bg-surface">
                                    <span class="flex size-7 shrink-0 items-center justify-center rounded-[7px] border border-border text-title-foreground">
                                        <span aria-hidden="true" class="iconify ph--terminal text-sm" x-show="!copied"></span>
                                        <span aria-hidden="true" class="iconify ph--check text-sm text-success" x-show="copied" x-cloak></span>
                                    </span>
                                    <span class="truncate font-mono text-[12.5px] text-foreground">{{ $example['command'] }}</span>
                                </button>
                            </div>
                        </div>
                        <div x-data="copyText(@js($example['source']))" class="flex min-h-0 flex-1 flex-col bg-code">
                            <div class="flex h-11.5 shrink-0 items-center justify-between border-b border-white/7 pr-2.5 pl-4.5">
                                <span class="font-mono text-[13px] text-gray-50">{{ $example['key'] }}.blade.php</span>
                                <span class="flex gap-0.5">
                                    <span title="{{ substr_count(rtrim($example['source']), "\n") + 1 }} lines · Blade" aria-label="About this file"
                                        class="flex size-8 items-center justify-center rounded-lg text-gray-400">
                                        <span aria-hidden="true" class="iconify ph--info"></span>
                                    </span>
                                    <button type="button" x-on:click="copy()" aria-label="Copy code"
                                        class="flex size-8 cursor-pointer items-center justify-center rounded-lg text-gray-400 hover:bg-white/5">
                                        <span aria-hidden="true" class="iconify ph--clipboard-text" x-show="!copied"></span>
                                        <span aria-hidden="true" class="iconify ph--check text-success" x-show="copied" x-cloak></span>
                                    </button>
                                </span>
                            </div>
                            <x-code-panel.code :code="$example['source']" />
                        </div>
                    </div>
                @endforeach
            </x-ui.slideover.content>
        </x-ui.slideover>
    </main>
</x-layouts::site>
