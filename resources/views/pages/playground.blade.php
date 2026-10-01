{{--
    Playground : l'aperçu est une iframe (le responsive y est réel), les
    réglages écrivent les tokens Flexiwind dedans et produisent le CSS.
--}}
<x-layouts::site>
    <main x-data="playground">
        {{-- Barre d'outils --}}
        <x-site.section>
            <x-site.container class="flex min-h-14 flex-wrap items-center justify-between gap-3 py-2.5">
                <div class="flex items-center gap-1">
                    <span class="font-display mr-2 text-[15px] font-semibold text-title-foreground">Playground</span>
                    <x-ui.button variant="ghost" intent="gray" size="sm" icon-only aria-label="Undo" x-on:click="undo()"
                        x-bind:disabled="position === 0" class="rounded-[9px]">
                        <span aria-hidden="true" class="iconify ph--arrow-u-up-left"></span>
                    </x-ui.button>
                    <x-ui.button variant="ghost" intent="gray" size="sm" icon-only aria-label="Redo" x-on:click="redo()"
                        x-bind:disabled="position === history.length - 1" class="rounded-[9px]">
                        <span aria-hidden="true" class="iconify ph--arrow-u-up-right"></span>
                    </x-ui.button>
                    <x-ui.button variant="ghost" intent="gray" size="sm" icon-only aria-label="Reset theme" x-on:click="reset()" class="rounded-[9px]">
                        <span aria-hidden="true" class="iconify ph--arrow-counter-clockwise"></span>
                    </x-ui.button>
                    <x-ui.button variant="ghost" intent="gray" size="sm" icon-only aria-label="Shuffle theme" x-on:click="shuffle()" class="rounded-[9px]">
                        <span aria-hidden="true" class="iconify ph--shuffle"></span>
                    </x-ui.button>
                </div>
                <div role="tablist" aria-label="Scene" class="order-3 flex w-full gap-0.5 rounded-[10px] bg-subtle p-0.75 sm:order-none sm:w-auto">
                    @foreach (['components' => 'Components', 'dashboard' => 'Dashboard', 'auth' => 'Auth'] as $key => $label)
                        <button type="button" role="tab" x-on:click="scene = '{{ $key }}'" x-bind:aria-selected="scene === '{{ $key }}'"
                            x-bind:class="scene === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 flex-1 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                    @endforeach
                </div>
                <div class="flex items-center gap-2">
                    <x-ui.slideover.trigger slide-over-id="playground-css" variant="outline" intent="gray"
                        class="h-8.5 gap-1.75 rounded-[9px] px-3 text-[13px] font-medium text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--code"></span>Theme CSS
                    </x-ui.slideover.trigger>
                    <x-ui.button size="sm" x-on:click="copyTheme()" class="h-8.5 gap-1.75 rounded-[9px] px-3 text-[13px] font-medium">
                        <span aria-hidden="true" class="iconify ph--copy" x-show="!copied"></span>
                        <span aria-hidden="true" class="iconify ph--check" x-show="copied" x-cloak></span>
                        <span x-text="copied ? 'Copied' : 'Copy theme'">Copy theme</span>
                    </x-ui.button>
                </div>
            </x-site.container>
        </x-site.section>

        {{-- Aperçu --}}
        <x-site.section>
            <div class="bg-dots relative flex h-[calc(100dvh-8rem)] min-h-150 justify-center overflow-hidden bg-surface p-3 sm:p-4">
                <div x-bind:style="`width:${frameWidth}`"
                    class="flex h-full max-w-full flex-col overflow-hidden rounded-[14px] bg-background shadow-[0_0_0_1px_var(--color-border),0_24px_50px_-30px_rgba(9,9,11,.35)] transition-[width] duration-300">
                    <div class="flex h-9 shrink-0 items-center gap-3 border-b border-border px-3">
                        <span class="flex gap-1.5">
                            <span class="size-2.5 rounded-full bg-border-strong"></span>
                            <span class="size-2.5 rounded-full bg-border-strong"></span>
                            <span class="size-2.5 rounded-full bg-border-strong"></span>
                        </span>
                        <span class="flex-1 truncate text-center font-mono text-xs text-muted-foreground" x-text="'acme.test/' + scene"></span>
                        <span class="font-mono text-[11.5px] text-subtitle" x-text="viewport === 'desktop' ? 'Full width' : frameWidth"></span>
                    </div>
                    <iframe x-ref="frame" title="Theme preview" x-bind:src="'{{ route('playground.preview') }}?scene=' + scene"
                        x-on:load="apply()" class="w-full flex-1 bg-background"></iframe>
                </div>

                {{-- Dock --}}
                <div role="toolbar" aria-label="Preview tools"
                    class="absolute bottom-5.5 left-1/2 z-20 flex h-12.5 -translate-x-1/2 items-center gap-0.5 rounded-full border border-border bg-background/88 px-1.5 shadow-[0_18px_40px_-18px_rgba(9,9,11,.35)] backdrop-blur-md">
                    @foreach (['desktop' => 'ph--laptop', 'tablet' => 'ph--device-tablet-camera', 'mobile' => 'ph--device-mobile-camera'] as $size => $icon)
                        <button type="button" x-on:click="viewport = '{{ $size }}'" x-bind:aria-pressed="viewport === '{{ $size }}'" aria-label="{{ ucfirst($size) }} width"
                            x-bind:class="viewport === '{{ $size }}' ? 'bg-subtle text-title-foreground' : 'text-muted-foreground'"
                            class="hidden size-9.5 cursor-pointer items-center justify-center rounded-full sm:flex">
                            <span aria-hidden="true" class="iconify {{ $icon }} text-lg"></span>
                        </button>
                    @endforeach
                    <span class="mx-1.5 hidden h-5 w-px bg-border sm:block"></span>
                    <button type="button" x-on:click="dark = !dark" aria-label="Toggle preview theme"
                        class="flex size-9.5 cursor-pointer items-center justify-center rounded-full text-muted-foreground hover:text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--sun text-lg" x-show="dark" x-cloak></span>
                        <span aria-hidden="true" class="iconify ph--moon-stars text-lg" x-show="!dark"></span>
                    </button>
                    <a x-bind:href="'{{ route('playground.preview') }}?scene=' + scene" target="_blank" aria-label="Open preview in a new tab"
                        class="flex size-9.5 items-center justify-center rounded-full text-muted-foreground hover:text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--arrow-square-out text-lg"></span>
                    </a>
                    <span class="mx-1.5 h-5 w-px bg-border"></span>
                    <button type="button" x-on:click="customizerOpen = !customizerOpen" x-bind:aria-expanded="customizerOpen" aria-label="Customize theme"
                        x-bind:style="`background:${dark ? accent.c5 : accent.c6};color:${accent.mono && dark ? '#09090b' : '#fff'}`"
                        class="flex size-9.5 cursor-pointer items-center justify-center rounded-full">
                        <span aria-hidden="true" class="iconify ph--paint-brush text-lg"></span>
                    </button>
                </div>

                {{-- Personnalisation --}}
                <div x-show="customizerOpen" x-transition.opacity.duration.150ms role="dialog" aria-label="Customize theme"
                    class="absolute right-3 bottom-21 left-3 z-20 mx-auto max-h-[calc(100%-7rem)] max-w-95 overflow-y-auto rounded-[18px] border border-border bg-background shadow-[0_30px_60px_-24px_rgba(9,9,11,.4)]">
                    <div class="sticky top-0 z-10 flex h-12.5 items-center justify-between border-b border-border bg-background pr-2.5 pl-4.5">
                        <span class="flex items-center gap-2">
                            <span class="font-display text-[15px] font-semibold text-title-foreground">Customize</span>
                            <span class="rounded-md bg-subtle px-1.75 py-0.5 text-[11.5px] text-muted-foreground" x-text="preset ? preset.name : 'Custom'"></span>
                        </span>
                        <x-ui.button variant="ghost" intent="gray" size="xs" icon-only aria-label="Close" x-on:click="customizerOpen = false" class="size-7.5 rounded-lg">
                            <span aria-hidden="true" class="iconify ph--x"></span>
                        </x-ui.button>
                    </div>
                    <div class="flex flex-col gap-4.5 p-4.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[12.5px] font-semibold text-title-foreground">Theme</span>
                            <div class="flex gap-0.5 rounded-[9px] bg-subtle p-0.75">
                                @foreach (['light' => ['ph--sun', 'Light', 'false'], 'dark' => ['ph--moon', 'Dark', 'true']] as $mode => [$icon, $label, $value])
                                    <button type="button" x-on:click="dark = {{ $value }}"
                                        x-bind:class="dark === {{ $value }} ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                                        class="flex h-7 cursor-pointer items-center gap-1.5 rounded-[7px] px-2.5 text-[12.5px] font-medium">
                                        <span aria-hidden="true" class="iconify {{ $icon }} text-xs"></span>{{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <x-site.playground-field label="Presets">
                            <div class="grid grid-cols-5 gap-1.5">
                                <template x-for="item in presets" :key="item.key">
                                    <button type="button" x-on:click="set({ accent: item.accent, base: item.base, radius: item.radius, form: item.form, font: item.font })"
                                        x-bind:aria-pressed="preset === item"
                                        x-bind:class="preset === item ? 'border-primary ring-3 ring-primary/15' : 'border-border'"
                                        class="flex cursor-pointer flex-col gap-1.25 rounded-[10px] border p-1.25 pb-1.5">
                                        <span class="flex h-7.5 overflow-hidden rounded-md">
                                            <span class="flex-2" x-bind:style="`background:${accents.find((a) => a.key === item.accent).c6}`"></span>
                                            <span class="flex-1" x-bind:style="`background:${bases.find((b) => b.key === item.base).c[3]}`"></span>
                                            <span class="flex-1" x-bind:style="`background:${bases.find((b) => b.key === item.base).c[8]}`"></span>
                                        </span>
                                        <span class="text-[11px] font-medium text-title-foreground" x-text="item.name"></span>
                                    </button>
                                </template>
                            </div>
                        </x-site.playground-field>

                        <x-site.playground-field label="Accent" value="accent.name">
                            <div class="flex flex-wrap justify-between gap-1">
                                <template x-for="item in accents" :key="item.key">
                                    <button type="button" x-on:click="set({ accent: item.key })" x-bind:aria-label="item.name" x-bind:aria-pressed="config.accent === item.key"
                                        x-bind:style="`border-color:${config.accent === item.key ? (dark ? item.c5 : item.c6) : 'transparent'}`"
                                        class="flex size-8.5 cursor-pointer items-center justify-center rounded-full border-2">
                                        <span class="size-6 rounded-full shadow-[inset_0_0_0_1px_rgba(128,128,128,.25)]" x-bind:style="`background:${dark ? item.c5 : item.c6}`"></span>
                                    </button>
                                </template>
                            </div>
                        </x-site.playground-field>

                        <x-site.playground-field label="Base" value="base.name">
                            <div class="grid grid-cols-5 gap-1.5">
                                <template x-for="item in bases" :key="item.key">
                                    <button type="button" x-on:click="set({ base: item.key })" x-bind:aria-pressed="config.base === item.key"
                                        x-bind:class="config.base === item.key ? 'border-primary ring-3 ring-primary/15' : 'border-border'"
                                        class="flex h-8.5 cursor-pointer items-center justify-center gap-1.5 rounded-[10px] border text-xs text-title-foreground">
                                        <span class="size-2.5 rounded-full" x-bind:style="`background:${item.c[5]}`"></span>
                                        <span class="hidden min-[400px]:inline" x-text="item.name"></span>
                                    </button>
                                </template>
                            </div>
                        </x-site.playground-field>

                        <x-site.playground-field label="Font">
                            <div class="grid grid-cols-4 gap-1.5">
                                <template x-for="item in fonts" :key="item[0]">
                                    <button type="button" x-on:click="set({ font: item[0] })" x-bind:aria-pressed="config.font === item[0]"
                                        x-bind:class="config.font === item[0] ? 'border-primary ring-3 ring-primary/15' : 'border-border'"
                                        class="flex h-14.5 cursor-pointer flex-col items-center justify-center gap-0.5 rounded-[10px] border">
                                        <span class="text-[19px]/6 font-semibold text-title-foreground" x-bind:style="`font-family:${item[2]},sans-serif`">Aa</span>
                                        <span class="text-[11px] whitespace-nowrap text-muted-foreground" x-text="item[1]"></span>
                                    </button>
                                </template>
                            </div>
                        </x-site.playground-field>

                        @foreach (['radius' => ['Radius', 'radii', 'cards, popovers, modals'], 'form' => ['Form radius', 'formRadii', 'buttons, inputs, selects']] as $key => [$label, $list, $hint])
                            <x-site.playground-field :label="$label" :hint="$hint">
                                <div class="grid grid-cols-6 gap-1.5">
                                    <template x-for="item in {{ $list }}" :key="item[0]">
                                        <button type="button" x-on:click="set({ {{ $key }}: item[0] })" x-bind:aria-pressed="config.{{ $key }} === item[0]"
                                            x-bind:class="config.{{ $key }} === item[0] ? 'border-primary ring-3 ring-primary/15 text-title-foreground' : 'border-border text-muted-foreground'"
                                            class="flex h-13 cursor-pointer flex-col items-center justify-center gap-1.25 rounded-[10px] border">
                                            <span class="size-4 border-t-2 border-l-2 border-current" x-bind:style="`border-top-left-radius:${item[0] === 'full' ? '16px' : item[2]}`"></span>
                                            <span class="text-[11px]" x-text="item[1]"></span>
                                        </button>
                                    </template>
                                </div>
                            </x-site.playground-field>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-site.section>

        {{-- CSS du thème --}}
        <x-ui.slideover id="playground-css" size="3xl" :closable="false">
            <x-ui.slideover.content class="bg-background">
                <div class="flex flex-col gap-4 border-b border-border px-6 pt-5.5 pb-4.5">
                    <div class="flex items-start justify-between gap-4">
                        <span class="flex flex-col gap-1.5">
                            <span class="font-display text-2xl font-semibold tracking-[-0.02em] text-title-foreground">Theme CSS</span>
                            <span class="text-[15px]/6 text-muted-foreground">
                                Paste it at the end of <code class="font-mono text-[13px] text-title-foreground">resources/css/app.css</code>.
                                Every Flexiwind component reads these tokens, so nothing else changes.
                            </span>
                        </span>
                        <x-ui.slideover.close variant="outline" intent="gray" icon-only aria-label="Close" class="size-8.5 shrink-0 rounded-[9px] text-title-foreground">
                            <span aria-hidden="true" class="iconify ph--x"></span>
                        </x-ui.slideover.close>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-[12.5px] text-foreground">
                        <span class="flex h-7 items-center gap-1.75 rounded-lg border border-border px-2.5"><span class="size-3 rounded" x-bind:style="`background:${accent.c6}`"></span><span x-text="accent.name"></span></span>
                        <span class="flex h-7 items-center gap-1.75 rounded-lg border border-border px-2.5"><span class="size-3 rounded" x-bind:style="`background:${base.c[5]}`"></span><span x-text="base.name + ' base'"></span></span>
                        <span class="flex h-7 items-center rounded-lg border border-border px-2.5" x-text="font[1]"></span>
                        <span class="flex h-7 items-center rounded-lg border border-border px-2.5" x-text="'Radius ' + radius[1]"></span>
                        <span class="flex h-7 items-center rounded-lg border border-border px-2.5" x-text="'Form ' + formRadius[1]"></span>
                    </div>
                </div>
                <div class="flex min-h-0 flex-1 flex-col bg-code">
                    <div class="flex h-11.5 shrink-0 items-center justify-between border-b border-white/7 pr-2.5 pl-4.5">
                        <span class="font-mono text-[13px] text-gray-50">app.css</span>
                        <button type="button" x-on:click="copyTheme()" aria-label="Copy theme CSS"
                            class="flex h-7 cursor-pointer items-center gap-1.5 rounded-[7px] border border-white/10 bg-white/4 px-2.5 text-xs text-gray-200 hover:bg-white/8">
                            <span aria-hidden="true" class="iconify ph--copy" x-show="!copied"></span>
                            <span aria-hidden="true" class="iconify ph--check text-success" x-show="copied" x-cloak></span>
                            <span x-text="copied ? 'Copied' : 'Copy'">Copy</span>
                        </button>
                    </div>
                    <pre class="min-h-0 flex-1 overflow-auto p-4.5 font-mono text-[12.5px]/5 text-gray-300" x-text="css"></pre>
                </div>
            </x-ui.slideover.content>
        </x-ui.slideover>
    </main>
</x-layouts::site>
