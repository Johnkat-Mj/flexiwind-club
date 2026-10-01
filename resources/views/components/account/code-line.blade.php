{{--
    Ligne de terminal copiable. `copy` est le texte copié ; le slot est ce
    qui s'affiche (il peut colorer une partie de la commande).
--}}
@props(['copy'])

<div x-data="copyText(@js($copy))" {{ $attributes->class([
    'flex min-h-9 items-center justify-between gap-2 rounded-[9px] bg-code py-1 pr-1.5 pl-3 font-mono text-xs text-code-foreground',
]) }}>
    <span class="min-w-0 overflow-x-auto whitespace-pre">{{ $slot->isEmpty() ? $copy : $slot }}</span>
    <button type="button" x-on:click="copy()" x-bind:aria-label="copied ? 'Copied' : 'Copy'"
        class="flex size-6.5 shrink-0 cursor-pointer items-center justify-center rounded-md text-code-muted transition-colors hover:bg-white/10 hover:text-code-foreground">
        <span aria-hidden="true" class="iconify ph--copy text-[13px]" x-show="!copied"></span>
        <span aria-hidden="true" class="iconify ph--check text-[13px] text-emerald-400" x-show="copied" x-cloak></span>
    </button>
</div>
