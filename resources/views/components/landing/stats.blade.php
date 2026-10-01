@props(['blockCount', 'freeCount'])

@php
    $stats = [
        ['icon' => 'ph--terminal-window', 'value' => '1 command', 'text' => 'php artisan flexi:add — and the component or block is in your repo.'],
        ['icon' => 'ph--squares-four', 'value' => $blockCount.' blocks', 'text' => 'Auth, dashboards, tables, settings and marketing — '.$freeCount.' of them free.'],
        ['icon' => 'ph--hand-heart', 'value' => '100% your code', 'text' => 'Plain Blade you read, edit and keep. No package to update, no lock-in.'],
    ];
@endphp

<x-site.section>
    <div class="mx-auto grid w-full max-w-300 divide-y divide-border md:grid-cols-3 md:divide-x md:divide-y-0">
        @foreach ($stats as $stat)
            <div class="flex items-start gap-4.5 px-6 py-8 lg:px-10">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-ui ui-soft ui-soft-gray">
                    <x-ui.icon name="{{ $stat['icon'] }}" size="lg"/>
                </span>
                <span class="flex flex-col gap-1">
                    <span class="font-display text-sm/[1.2] font-semibold tracking-[-0.03em] text-title-foreground">{{ $stat['value'] }}</span>
                    <span class="text-[12px] text-pretty text-muted-foreground">{{ $stat['text'] }}</span>
                </span>
            </div>
        @endforeach
    </div>
</x-site.section>
