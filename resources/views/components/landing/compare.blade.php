@props(['totals'])

@php
    $lowest = collect(App\Billing\Plan::all())->min(fn ($plan) => $plan->priceCents);
    $rows = [
        ['ph--cube', 'Components', '39 open-source primitives', '+ Advanced select, autocomplete, multi-select, charts, rich text'],
        ['ph--squares-four', 'Blocks', $totals['free'].' blocks', 'All '.$totals['total'].' blocks'],
        ['ph--file-text', 'Documentation', 'Full docs with live previews', '+ The source of every Pro example'],
        ['ph--terminal-window', 'CLI', 'The public registry', '+ The @fx/ registry with your own tokens'],
        ['ph--users-three', 'Team seats', '—', 'Up to 5 accounts with Team Lifetime'],
        ['ph--tag', 'Price', 'Free', 'From '.Illuminate\Support\Number::currency($lowest / 100, 'EUR', precision: 0)],
    ];
@endphp

<x-site.section>
    <x-site.container class="py-20 lg:py-28">
        <x-site.section-heading icon="ph--scales" eyebrow="Free vs Pro" title="Start open source." muted="Go Pro when it pays off.">
            The free library is complete on its own. Pro adds what saves days on client and product work.
        </x-site.section-heading>

        <div class="mt-14 overflow-x-auto rounded-[20px] border border-border bg-background shadow-xs">
            <div class="min-w-160">
                <div class="grid grid-cols-[minmax(180px,300px)_minmax(0,1fr)_minmax(0,1fr)]">
                    <span class="flex h-19 items-center px-7 text-[13px] font-medium text-muted-foreground">What you get</span>
                    <span class="font-display flex items-center px-7 text-xl font-semibold text-title-foreground">Open source</span>
                    <span class="flex items-center gap-2.5 bg-primary/4 px-7">
                        <span class="font-display text-xl font-semibold text-title-foreground">Pro</span>
                        <span class="rounded-full bg-primary px-2 py-0.5 text-xs font-semibold text-primary-foreground">Everything unlocked</span>
                    </span>
                </div>
                @foreach ($rows as [$icon, $label, $free, $pro])
                    <div class="grid grid-cols-[minmax(180px,300px)_minmax(0,1fr)_minmax(0,1fr)] border-t border-border text-[14.5px]">
                        <span class="flex h-16 items-center gap-2.5 px-7 font-medium text-title-foreground">
                            <span aria-hidden="true" class="iconify {{ $icon }} text-muted-foreground"></span>{{ $label }}
                        </span>
                        <span class="flex items-center px-7 text-foreground">{{ $free }}</span>
                        <span class="flex items-center bg-primary/4 px-7 text-title-foreground">{{ $pro }}</span>
                    </div>
                @endforeach
                <div class="grid grid-cols-[minmax(180px,300px)_minmax(0,1fr)_minmax(0,1fr)] border-t border-border">
                    <span></span>
                    <span class="flex px-7 py-5">
                        <x-ui.button href="/docs/introduction" wire:navigate variant="outline" intent="gray"
                            class="h-10.5 rounded-[10px] px-4 font-medium text-title-foreground">Read the docs</x-ui.button>
                    </span>
                    <span class="flex bg-primary/4 px-7 py-5">
                        <x-ui.button href="{{ route('pricing') }}" wire:navigate class="h-10.5 gap-2 rounded-[10px] px-4 font-medium">
                            Get Pro <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
                        </x-ui.button>
                    </span>
                </div>
            </div>
        </div>
    </x-site.container>
</x-site.section>
