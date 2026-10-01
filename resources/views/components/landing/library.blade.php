{{-- La bibliothèque : deux rangées de groupes qui défilent, puis les templates. --}}
@props(['totals'])

@php
    $groups = App\Support\BlockCatalog::illustrated();
    // Une illustration par groupe suffit : on écarte celles qui se répètent.
    $unique = collect($groups)->unique(fn (array $group): string => $group['illustrations']['light'])->values();
    $rows = [$unique->slice(0, (int) ceil($unique->count() / 2)), $unique->slice((int) ceil($unique->count() / 2))];
@endphp

<x-site.section class="overflow-hidden">
    <x-site.container class="flex flex-col items-center pt-20 lg:pt-28">
        <x-site.section-heading icon="ph--squares-four" eyebrow="The library" :title="$totals['total'].' blocks and counting.'" muted="Pick one, ship it.">
            Auth screens, app shells, dashboards, tables, settings and marketing sections — {{ $totals['free'] }} free,
            {{ $totals['pro'] }} in Pro, all with live previews.
        </x-site.section-heading>
        <div class="mt-7 flex flex-wrap justify-center gap-2.5">
            <x-ui.button href="{{ route('blocks.list') }}" wire:navigate class="h-11 gap-2 rounded-[10px] px-4.5 text-[15px] font-medium">
                Browse blocks <span aria-hidden="true" class="iconify ph--arrow-right text-sm"></span>
            </x-ui.button>
            <x-ui.button href="/components" wire:navigate variant="outline" intent="gray"
                class="h-11 rounded-[10px] px-4.5 text-[15px] font-medium text-title-foreground">See components</x-ui.button>
        </div>
    </x-site.container>

    <div class="mt-14 flex flex-col gap-4 mask-x-from-88% mask-x-to-100%">
        @foreach ($rows as $rowIndex => $row)
            <div class="flex w-max animate-marquee gap-4 hover:[animation-play-state:paused] {{ $rowIndex === 1 ? '[animation-direction:reverse]' : '' }}">
                @foreach ([...$row, ...$row] as $group)
                    <a href="{{ route('blocks.show', ['blockCategory' => $group['category'], 'blockName' => $group['key']]) }}" wire:navigate
                        class="flex w-75 shrink-0 flex-col gap-2.5 rounded-2xl border border-border bg-background p-1.5 transition-colors hover:border-border-strong">
                        <div class="h-45 overflow-hidden rounded-[11px] bg-surface">
                            <img src="{{ $group['illustrations']['light'] }}" alt="{{ $group['title'] }} blocks preview" loading="lazy" class="size-full object-cover dark:hidden">
                            <img src="{{ $group['illustrations']['dark'] ?? $group['illustrations']['light'] }}" alt="{{ $group['title'] }} blocks preview" loading="lazy" class="hidden size-full object-cover dark:block">
                        </div>
                        <div class="flex items-center justify-between gap-2 px-2 pb-2">
                            <span class="text-[15px] font-semibold text-title-foreground">{{ $group['title'] }}</span>
                            <span class="text-[12.5px] text-muted-foreground">{{ $group['total'] }} blocks @if ($group['pro'])· <span class="font-medium text-primary">{{ $group['pro'] }} Pro</span>@endif</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>

    <x-site.container class="pt-16 pb-20 lg:pt-18 lg:pb-28">
        <div class="grid overflow-hidden rounded-3xl border border-border bg-background shadow-xs lg:h-110 lg:grid-cols-[460px_minmax(0,1fr)]">
            <div class="flex flex-col gap-3.5 p-6 sm:p-10">
                <x-site.eyebrow icon="ph--layout" class="w-max">Templates</x-site.eyebrow>
                <span class="font-display mt-1 text-3xl/9 font-semibold tracking-[-0.025em] text-title-foreground">Start from a whole app.</span>
                <span class="text-[15px]/6 text-muted-foreground">Complete applications built with the same components, so every screen already speaks the same language.</span>
                <div class="mt-1.5 flex flex-col gap-2.5">
                    @foreach (config('templates') as $template)
                        <a href="{{ route('templates.show', $template['key']) }}" wire:navigate
                            class="flex items-center gap-3.5 rounded-[14px] border border-border bg-background p-3 transition-colors hover:border-border-strong">
                            <img src="/images/{{ $template['key'] === 'crm' ? 'crm-template' : 'starter' }}.webp" alt="" class="h-13.5 w-18 shrink-0 rounded-lg border border-border object-cover object-top">
                            <span class="flex flex-1 flex-col gap-0.5">
                                <span class="text-[15px] font-semibold text-title-foreground">{{ $template['title'] }}</span>
                                <span class="text-[13.5px] text-muted-foreground">{{ $template['summary'] }}</span>
                            </span>
                            <x-landing.tier-pill :free="$template['tier'] === 'free'" />
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="bg-dots relative hidden overflow-hidden border-l border-border bg-surface lg:block">
                <img src="/images/starter.webp" alt="" class="absolute top-9 left-37.5 aspect-4/3 w-115 rounded-xl border border-border object-cover opacity-85 shadow-[0_20px_40px_-24px_rgba(9,9,11,.3)] dark:hidden">
                <img src="/images/starter-dark.webp" alt="" class="absolute top-9 left-37.5 hidden aspect-4/3 w-115 rounded-xl border border-border object-cover opacity-85 dark:block">
                <img src="/images/crm-template.webp" alt="CRM template dashboard with lead, deal and revenue cards" class="absolute top-24 left-11 aspect-4/3 w-120 rounded-xl border border-border object-cover shadow-[0_30px_60px_-26px_rgba(9,9,11,.4)] dark:hidden">
                <img src="/images/crm-template-dark.webp" alt="CRM template dashboard with lead, deal and revenue cards" class="absolute top-24 left-11 hidden aspect-4/3 w-120 rounded-xl border border-border object-cover shadow-[0_30px_60px_-26px_rgba(9,9,11,.4)] dark:block">
            </div>
        </div>
    </x-site.container>
</x-site.section>
