{{--
    Vue éditeur pour un block en plusieurs fichiers : explorateur groupé par
    dossier, onglets, fil d'Ariane par fichier et barre d'état.
--}}
@props(['name', 'files', 'dependencies' => []])

@php
    $root = 'resources/views/components';
    $tree = [];
    foreach ($files as $index => $file) {
        $relative = str_starts_with($file['target'], $root.'/') ? substr($file['target'], strlen($root) + 1) : $file['target'];
        $folder = str_contains($relative, '/') ? dirname($relative) : '';
        $tree[$folder][] = ['index' => $index, 'name' => basename($relative)];
    }
    $allFiles = collect($files)->map(fn (array $file): string => "// {$file['target']}\n".$file['code'])->implode("\n\n");
@endphp

<div x-data="{ current: 0 }" class="absolute inset-0 flex bg-code">
    <aside class="hidden w-66 shrink-0 flex-col border-r border-white/6 bg-[#111114] md:flex">
        <div class="flex h-10 shrink-0 items-center justify-between border-b border-white/6 px-3.5">
            <span class="text-[11px] font-semibold tracking-[.08em] text-gray-400 uppercase">Explorer</span>
            <span class="text-[11px] text-gray-500">{{ count($files) }} files</span>
        </div>
        <div class="flex flex-1 flex-col gap-px overflow-auto px-1.5 py-2 font-mono text-xs">
            <span class="flex h-6.5 items-center gap-1.5 px-2.5 text-gray-400">
                <span aria-hidden="true" class="iconify ph--folder-open text-[13px]"></span>{{ $root }}
            </span>
            @foreach ($tree as $folder => $items)
                @if ($folder !== '')
                    <span class="flex h-6.5 items-center gap-1.5 pr-2.5 pl-6 text-gray-400">
                        <span aria-hidden="true" class="iconify ph--folder-open text-[13px]"></span>{{ $folder }}
                    </span>
                @endif
                @foreach ($items as $item)
                    <button type="button" x-on:click="current = {{ $item['index'] }}"
                        x-bind:class="current === {{ $item['index'] }} ? 'bg-indigo-300/12 text-gray-50 shadow-[inset_2px_0_0_var(--color-indigo-300)]' : 'text-gray-300 hover:bg-white/4'"
                        class="flex h-7 cursor-pointer items-center gap-1.75 rounded-md pr-2.5 pl-10 text-left">
                        <span aria-hidden="true" class="iconify ph--file-code text-[13px] text-indigo-300"></span>{{ $item['name'] }}
                    </button>
                @endforeach
            @endforeach
        </div>
        <div x-data="copyText({{ Js::from($allFiles) }})" class="flex flex-col gap-2 border-t border-white/6 px-3.5 py-3">
            @if ($dependencies !== [])
                <span class="text-[11px] font-semibold tracking-[.08em] text-gray-400 uppercase">Requires</span>
                <div class="flex flex-wrap gap-1.25"><x-code-panel.dependencies :dependencies="$dependencies" /></div>
            @endif
            <button type="button" x-on:click="copy()"
                class="mt-1 flex h-7.5 cursor-pointer items-center justify-center gap-1.5 rounded-[7px] border border-white/10 bg-white/4 text-xs text-gray-200 hover:bg-white/8">
                <span aria-hidden="true" class="iconify ph--copy text-[13px]" x-show="!copied"></span>
                <span aria-hidden="true" class="iconify ph--check text-[13px] text-success" x-show="copied" x-cloak></span>
                <span x-text="copied ? 'Copied' : 'Copy all {{ count($files) }} files'">Copy all {{ count($files) }} files</span>
            </button>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <div role="tablist" aria-label="Files" class="flex h-10 shrink-0 items-end overflow-x-auto border-b border-white/6 bg-[#111114]">
            @foreach ($files as $index => $file)
                <button type="button" role="tab" x-on:click="current = {{ $index }}" x-bind:aria-selected="current === {{ $index }}"
                    x-bind:class="current === {{ $index }} ? 'bg-code text-gray-50 shadow-[inset_0_2px_0_var(--color-indigo-300)]' : 'text-code-muted hover:text-gray-300'"
                    class="flex h-10 shrink-0 cursor-pointer items-center gap-1.75 border-r border-white/6 px-3 font-mono text-xs">
                    <span aria-hidden="true" class="iconify ph--file-code text-xs text-indigo-300"></span>{{ basename($file['target']) }}
                </button>
            @endforeach
        </div>
        <div class="relative min-h-0 flex-1">
            @foreach ($files as $index => $file)
                <div x-show="current === {{ $index }}" @if ($index > 0) x-cloak @endif
                    x-data="copyText({{ Js::from($file['code']) }})" class="absolute inset-0 flex flex-col">
                    <div class="flex h-8 shrink-0 items-center justify-between gap-3 border-b border-white/6 pr-2 pl-4">
                        <span class="truncate font-mono text-[11.5px] text-code-muted">{{ str_replace('/', ' › ', $file['target']) }}</span>
                        <button type="button" x-on:click="copy()" aria-label="Copy this file"
                            class="flex h-6 shrink-0 cursor-pointer items-center gap-1.25 rounded-md px-2 text-[11.5px] text-gray-400 hover:bg-white/5">
                            <span aria-hidden="true" class="iconify ph--copy text-xs" x-show="!copied"></span>
                            <span aria-hidden="true" class="iconify ph--check text-xs text-success" x-show="copied" x-cloak></span>
                            <span x-text="copied ? 'Copied' : 'Copy'">Copy</span>
                        </button>
                    </div>
                    <x-code-panel.code :code="$file['code']" />
                    <div class="flex h-6.5 shrink-0 items-center justify-between border-t border-white/6 bg-[#0f0f12] px-3.5 text-[11px] text-code-muted">
                        <span class="flex gap-3.5">
                            <span>Blade</span>
                            <span>{{ substr_count(rtrim($file['code']), "\n") + 1 }} lines</span>
                            <span class="hidden sm:inline">UTF-8</span>
                            <span class="hidden sm:inline">LF</span>
                        </span>
                        <span>{{ $name }} · {{ count($files) }} files</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
