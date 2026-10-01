@props(['target', 'code', 'dependencies' => []])

@php
    $lineCount = substr_count(rtrim($code), "\n") + 1;
@endphp

<div x-data="copyText({{ Js::from($code) }})" class="absolute inset-0 flex flex-col bg-code">
    <div class="flex h-11.5 shrink-0 items-center justify-between gap-3 border-b border-white/7 pr-2 pl-4">
        <span class="flex min-w-0 items-center gap-2 font-mono text-[12.5px]">
            <span aria-hidden="true" class="iconify ph--file-code shrink-0 text-sm text-indigo-300"></span>
            <x-code-panel.path :target="$target" />
        </span>
        <span class="flex shrink-0 items-center gap-2.5">
            <span class="hidden text-[11.5px] text-code-muted sm:inline">Blade · {{ $lineCount }} lines</span>
            <button type="button" x-on:click="copy()" aria-label="Copy file"
                class="flex h-7 cursor-pointer items-center gap-1.5 rounded-[7px] border border-white/10 bg-white/4 px-2.5 text-xs text-gray-200 transition-colors hover:bg-white/8">
                <span aria-hidden="true" class="iconify ph--copy text-[13px]" x-show="!copied"></span>
                <span aria-hidden="true" class="iconify ph--check text-[13px] text-success" x-show="copied" x-cloak></span>
                <span x-text="copied ? 'Copied' : 'Copy'">Copy</span>
            </button>
        </span>
    </div>
    <x-code-panel.code :code="$code" />
    @if ($dependencies !== [])
        <div class="flex min-h-9.5 shrink-0 flex-wrap items-center gap-2 border-t border-white/7 bg-white/2 px-4 py-2">
            <span class="text-[11.5px] text-code-muted">Requires</span>
            <x-code-panel.dependencies :dependencies="$dependencies" />
            <span class="ml-auto hidden text-[11.5px] text-gray-500 sm:inline">added by flexi:add</span>
        </div>
    @endif
</div>
