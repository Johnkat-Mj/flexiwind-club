{{--
    Boîte de confirmation pilotée par Livewire : affichée tant que la
    condition est vraie côté serveur. Pas de modal JS à synchroniser, et
    l'action confirmée est revérifiée par le composant.
--}}
@props(['show' => false, 'title', 'icon' => 'ph--warning', 'cancel', 'confirm', 'confirmLabel'])

@if ($show)
    <div class="fixed inset-0 z-80 flex items-center justify-center p-4" x-data x-on:keydown.escape.window="$wire.{{ $cancel }}()">
        <button type="button" aria-label="Close" wire:click="{{ $cancel }}"
            class="absolute inset-0 cursor-default bg-gray-900/45 backdrop-blur-xs"></button>
        <div role="alertdialog" aria-modal="true" aria-labelledby="confirm-title"
            class="relative flex w-full max-w-105 flex-col gap-3 rounded-[18px] border border-border bg-background p-6 shadow-2xl">
            <span class="flex size-11 items-center justify-center rounded-full bg-red-600/12 text-red-600 dark:text-red-400">
                <span aria-hidden="true" class="iconify {{ $icon }} text-xl"></span>
            </span>
            <h2 id="confirm-title" class="font-display text-lg font-semibold text-title-foreground">{{ $title }}</h2>
            <p class="text-sm/[21px] text-muted-foreground">{{ $slot }}</p>
            <div class="mt-2 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <x-ui.button type="button" wire:click="{{ $cancel }}" variant="outline" intent="gray" class="font-medium">Cancel</x-ui.button>
                <x-ui.button type="button" wire:click="{{ $confirm }}" x-init="$el.focus()" variant="solid" intent="danger" class="font-medium">
                    {{ $confirmLabel }}
                </x-ui.button>
            </div>
        </div>
    </div>
@endif
