<x-layouts::site>
    <main x-data="chartsPage">
        <x-site.section>
            <x-site.container class="flex min-h-14 items-center py-2.5">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm">
                    <a href="/components" wire:navigate class="text-muted-foreground hover:text-title-foreground">Components</a>
                    <span aria-hidden="true" class="iconify ph--caret-right text-xs text-border-strong"></span>
                    <span class="font-medium text-title-foreground">Charts</span>
                </nav>
            </x-site.container>
        </x-site.section>

        <x-site.page-header icon="ph--chart-bar" eyebrow="Components · Charts" title="Charts" muted="for dashboards.">
            Bar, line and pie charts that read your theme tokens — part of Flexiwind Pro. Switch the range to see them update.
            <x-slot:actions>
                <span class="flex h-6.5 items-center gap-1.5 rounded-full border border-dashed border-border-strong px-2.5 text-[12.5px] text-muted-foreground">
                    <span class="size-1.5 rounded-full bg-amber-600"></span>In progress
                </span>
                <div role="tablist" aria-label="Range" class="flex gap-0.5 rounded-[10px] bg-subtle p-0.75">
                    @foreach (['7d' => '7 days', '30d' => '30 days', '12m' => '12 months'] as $key => $label)
                        <button type="button" role="tab" x-on:click="range = '{{ $key }}'" x-bind:aria-selected="range === '{{ $key }}'"
                            x-bind:class="range === '{{ $key }}' ? 'bg-background text-title-foreground shadow-xs ring-1 ring-border' : 'text-muted-foreground'"
                            class="h-7.5 cursor-pointer rounded-[7px] px-3 text-[13px] font-medium transition-all">{{ $label }}</button>
                    @endforeach
                </div>
            </x-slot:actions>
        </x-site.page-header>

        <x-site.section>
            <div class="mx-auto flex w-full max-w-300 flex-col gap-11 pt-9 pb-16 sm:px-2 lg:px-4">
                {{-- Barres --}}
                <x-site.preview-frame name="bar-chart" tier="pro">
                    <x-site.chart-card title="Revenue" value="data.revenue" delta="data.revenueDelta">
                        <x-slot:legend>
                            <div class="flex gap-1.5">
                                @foreach (['showSubscriptions' => ['Subscriptions', 'bg-[#4f46e5]'], 'showOneTime' => ['One-time', 'bg-[#0e7490]']] as $flag => [$label, $color])
                                    <button type="button" x-on:click="{{ $flag }} = !{{ $flag }}" x-bind:aria-pressed="{{ $flag }}"
                                        x-bind:class="{{ $flag }} ? 'border-solid border-border bg-background text-title-foreground' : 'border-dashed border-border text-subtitle line-through'"
                                        class="flex h-7 cursor-pointer items-center gap-1.5 rounded-lg border px-2.5 text-[12.5px] transition-all">
                                        <span class="size-2.25 rounded-[3px] {{ $color }}"></span>{{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </x-slot:legend>
                        <div class="flex min-h-0 flex-1 gap-2 bg-[linear-gradient(var(--color-border)_1px,transparent_1px)] bg-size-[100%_52px] px-1 sm:gap-3.5">
                            <template x-for="bar in bars" :key="bar.label">
                                <div class="flex flex-1 flex-col items-center gap-2">
                                    <div class="flex min-h-0 w-full flex-1 items-end justify-center gap-1">
                                        <span class="w-2/5 max-w-6.5 rounded-t-[5px] bg-[#4f46e5] transition-all duration-300" x-bind:style="`height:${bar.a}%;opacity:${bar.a ? 1 : 0}`"></span>
                                        <span class="w-2/5 max-w-6.5 rounded-t-[5px] bg-[#0e7490] transition-all duration-300" x-bind:style="`height:${bar.b}%;opacity:${bar.b ? 1 : 0}`"></span>
                                    </div>
                                    <span class="text-[11.5px] whitespace-nowrap text-muted-foreground" x-text="bar.label"></span>
                                </div>
                            </template>
                        </div>
                    </x-site.chart-card>
                </x-site.preview-frame>

                {{-- Courbe --}}
                <x-site.preview-frame name="line-chart" tier="pro">
                    <x-site.chart-card title="Active users" value="latestUsers" delta="data.usersDelta">
                        <div class="relative min-h-0 flex-1">
                            <svg viewBox="0 0 800 220" preserveAspectRatio="none" class="block size-full overflow-visible" role="img" aria-label="Active users over time">
                                <g class="stroke-border" stroke-width="1">
                                    <line x1="0" y1="55" x2="800" y2="55"></line>
                                    <line x1="0" y1="110" x2="800" y2="110"></line>
                                    <line x1="0" y1="165" x2="800" y2="165"></line>
                                </g>
                                <path x-bind:d="linePath + ' L800 220 L0 220 Z'" fill="#4f46e5" fill-opacity="0.08"></path>
                                <path x-bind:d="linePath" fill="none" stroke="#4f46e5" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <div class="absolute right-4.5 flex flex-col gap-0.5 rounded-[9px] border border-border bg-background px-2.5 py-2 shadow-[0_8px_20px_-10px_rgba(9,9,11,.3)] transition-[top] duration-300"
                                x-bind:style="`top:calc(${lastPointTop}% - 64px)`">
                                <span class="text-[11px] text-muted-foreground" x-text="data.labels[data.labels.length - 1]"></span>
                                <span class="text-sm font-semibold text-title-foreground" x-text="latestUsers + ' users'"></span>
                            </div>
                            <span class="absolute left-full size-3 -translate-1/2 rounded-full bg-[#4f46e5] shadow-[0_0_0_4px_var(--color-background),0_0_0_5px_#4f46e5] transition-[top] duration-300"
                                x-bind:style="`top:${lastPointTop}%`"></span>
                        </div>
                        <div class="flex justify-between px-0.5">
                            <template x-for="label in data.labels" :key="label">
                                <span class="text-[11.5px] text-muted-foreground" x-text="label"></span>
                            </template>
                        </div>
                    </x-site.chart-card>
                </x-site.preview-frame>

                {{-- Donut --}}
                <x-site.preview-frame name="pie-chart" tier="pro">
                    <x-site.chart-card title="Traffic sources" value="data.visits" delta="data.visitsDelta">
                        <div class="flex min-h-0 flex-1 flex-col items-center gap-6 sm:flex-row sm:gap-12 sm:pl-6">
                            <div class="relative size-44 shrink-0 sm:size-55">
                                <svg viewBox="0 0 200 200" class="size-full -rotate-90" role="img" aria-label="Traffic sources">
                                    <circle cx="100" cy="100" r="70" fill="none" class="stroke-subtle" stroke-width="28"></circle>
                                    @foreach (range(0, 3) as $index)
                                        <circle cx="100" cy="100" r="70" fill="none" class="transition-[stroke-width] duration-200"
                                            x-bind:stroke="slices[{{ $index }}].color" x-bind:stroke-width="slices[{{ $index }}].width"
                                            x-bind:stroke-dasharray="slices[{{ $index }}].dash" x-bind:stroke-dashoffset="slices[{{ $index }}].offset"></circle>
                                    @endforeach
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="font-display text-[26px] font-semibold text-title-foreground" x-text="data.traffic[source] + '%'"></span>
                                    <span class="text-xs text-muted-foreground" x-text="sources[source][0]"></span>
                                </div>
                            </div>
                            <div class="flex w-full flex-1 flex-col gap-1.5">
                                <template x-for="([name, color], index) in sources" :key="name">
                                    <button type="button" x-on:click="source = index"
                                        x-bind:class="source === index ? 'border-border bg-surface' : 'border-transparent'"
                                        class="flex h-10 cursor-pointer items-center justify-between rounded-[10px] border px-3 text-[13.5px] text-foreground transition-all">
                                        <span class="flex items-center gap-2.5"><span class="size-2.5 rounded-[3px]" x-bind:style="`background:${color}`"></span><span x-text="name"></span></span>
                                        <span class="font-mono text-[13px] text-title-foreground" x-text="data.traffic[index] + '%'"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </x-site.chart-card>
                </x-site.preview-frame>
            </div>
        </x-site.section>
    </main>
</x-layouts::site>
