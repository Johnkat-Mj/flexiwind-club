{{--
    Présentation d'un composant avec aperçu intégré : mêmes onglets, même
    commande et même badge Pro que x-v-ui.single-block, mais l'aperçu est
    rendu dans la page au lieu d'une iframe.
--}}
@props(['name', 'tier' => 'free', 'height' => 'h-115'])

@php
    $isPro = $tier === 'pro';
    $command = 'php artisan flexi:add '.($isPro ? '@fx/' : '').$name;
    $canSeeSource = ! $isPro || Flexiwind\Docs\Tier::current()->grants(Flexiwind\Docs\Tier::Pro);
@endphp

<article x-data="{ view: 'preview' }" {{ $attributes->class('relative w-full px-2') }}>
    <div class="flex h-12 items-center justify-between gap-2 px-3.5">
        <div role="tablist" aria-label="{{ $name }}" class="flex items-center gap-0.5 text-sm text-muted-foreground">
            @foreach (['preview' => ['ph--eye', 'Preview'], 'code' => ['ph--code', 'Code']] as $view => [$icon, $label])
                <button type="button" role="tab" x-on:click="view = '{{ $view }}'" x-bind:aria-selected="view === '{{ $view }}'"
                    x-bind:class="view === '{{ $view }}' ? 'bg-white text-title-foreground shadow ring-gray-200 dark:bg-gray-800 dark:ring-gray-700/60' : 'ring-transparent'"
                    class="flex cursor-pointer items-center gap-1 rounded-ui px-2.5 py-1 ring-1">
                    <span aria-hidden="true" class="iconify {{ $icon }} size-3 opacity-80"></span>
                    <span class="hidden sm:flex">{{ $label }}</span>
                </button>
            @endforeach
        </div>
        <div class="ml-1.5 flex flex-1 items-center gap-0.5 border-l border-border pl-2">
            <span class="font-mono text-xs text-muted-foreground">{{ $name }}</span>
        </div>
        <div class="flex min-w-max items-center gap-2 text-foreground">
            @if ($isPro)
                <x-fw-docs::pro-badge />
            @endif
            <button type="button" x-data="copyText(@js($command))" x-on:click="copy()"
                class="hidden h-8 cursor-pointer items-center gap-1.5 rounded-md border border-border/50 bg-background pr-3 pl-2 text-xs shadow hover:bg-surface sm:flex">
                <span aria-hidden="true" class="iconify ph--terminal" x-show="!copied"></span>
                <span aria-hidden="true" class="iconify ph--check text-success" x-show="copied" x-cloak></span>
                <span class="text-muted-foreground">{{ $command }}</span>
            </button>
        </div>
    </div>
    <div class="relative {{ $height }} overflow-hidden rounded-ui bg-background ring ring-border-card">
        <div x-show="view === 'preview'" class="absolute inset-0 flex">{{ $slot }}</div>
        <div x-show="view === 'code'" x-cloak class="absolute inset-0">
            @if ($canSeeSource)
                <x-code-panel.block :name="$name" :tier="$tier" class="h-full" />
            @else
                <x-fw-docs::locked variant="panel" :example="$name" />
            @endif
        </div>
    </div>
</article>
