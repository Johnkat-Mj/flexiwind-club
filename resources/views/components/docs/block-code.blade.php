@props(['title', 'icon' => null, 'shellStyle' => null, 'noTitle' => false])

@php
    $iconVal = null;

    if ($icon) {
        $iconVal = \App\Helpers\CodeIcon::get($icon);
    }
@endphp


@if (!$noTitle)
    <div class="flex justify-between items-center pl-3.5 pr-2.5 pb-1.5 pt-px">
        <div class="flex items-center gap-x-3">
            @if ($iconVal)
                @if (\App\Helpers\CodeIcon::isFile($iconVal))
                    <img src="{{ '/icons/' . $iconVal }}" alt="icon {{ $icon }}" width="20"
                        class="h-3.5 w-auto" />
                @else
                    <span aria-hidden="true" class="flex iconify {{ $iconVal }}"></span>
                @endif
            @endif
            {{ $title }}
        </div>
        <div class="flex items-center text-gray-200">
            <x-atoms.btn-copy-code />
        </div>
    </div>
@endif
<div class="relative group overflow-hidden max-h-140 xl:max-h-160 bg-(--astro-code-color-background) w-full grid">

    <div data-shell-indicator="{{ $shellStyle ? 'true' : 'false' }}" data-code-snippet class="grid overflow-hidden">
        {{ $slot }}
    </div>
    @if ($noTitle)
        <div
            class="absolute top-4 right-4 z-40 invisible flex opacity-0 group-hover:visible group-hover:opacity-100 text-gray-300">
            <x-atoms.btn-copy-code />
        </div>
    @endif
</div>
