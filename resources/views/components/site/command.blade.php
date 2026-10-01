{{-- Ligne de terminal sombre avec bouton de copie. --}}
@props(['command', 'prompt' => '$'])

<div x-data="copyText(@js($command))"
    {{ $attributes->class('flex h-10 items-center justify-between gap-2.5 rounded-[10px] bg-code pr-1.25 pl-3.5 font-mono text-[13px] text-code-foreground') }}>
    <span class="truncate"><span class="text-code-muted">{{ $prompt }} </span>{{ $command }}</span>
    <button type="button" x-on:click="copy()" aria-label="Copy command"
        class="flex size-7.5 shrink-0 cursor-pointer items-center justify-center rounded-md text-code-muted transition-colors hover:bg-white/5 hover:text-code-foreground">
        <span aria-hidden="true" class="iconify ph--copy text-sm" x-show="!copied"></span>
        <span aria-hidden="true" class="iconify ph--check text-sm text-success" x-show="copied" x-cloak></span>
    </button>
</div>
