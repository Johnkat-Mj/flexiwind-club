<?php

use Livewire\Component;

new class extends Component {
    public string $key_ui = '';

    public string $title = '';

    public string $preview = '';

    public array $code = [];
    public bool $isFullScreen = false;

    public function mount(string $keyUi, string $preview, string $title, array $code, bool $isFullScreen)
    {
        $this->key_ui = $keyUi;
        $this->title = $title;
        $this->preview = $preview;
        $this->code = $code;
    }
};
?>

@php
    $sizeTriggers = [
        [
            'isActive' => true,
            'target' => 'desktop',
            'icon' => 'ph--laptop',
        ],
        [
            'isActive' => false,
            'target' => 'tablet',
            'icon' => 'ph--device-tablet-camera',
        ],
        [
            'isActive' => false,
            'target' => 'mobile',
            'icon' => 'ph--device-mobile-camera',
        ],
    ];
@endphp

<article x-data x-ui-block wire:key="card-wrapper-{{ $key_ui }}" class="relative w-full">

    <x-ui.tabs class="relative lg:max-w-336 xl:max-w-352 lg:mx-auto px-2 sm:px-4 xl:px-8 w-full">
        <x-ui.tabs.list-wrapper class="w-full flex justify-between items-center gap-2 h-12 px-3.5 relative">
            <x-ui.tabs.list unStyled class="flex items-center gap-0.5 text-sm text-fg-muted">
                <x-ui.tabs.trigger unStyled wrapper-class="flex"
                    class="relative flex items-center gap-1 disabled:cursor-not-allowed disabled:opacity-80 fx-active:text-fg-title outline-none focus:outline-0 focus:outline-transparent focus-visible:outline focus-visible:outline-primary px-2.5 py-1 rounded-(--global-main-radius) fx-active:bg-white fx-active:dark:bg-gray-800 ring-1 ring-transparent fx-active:ring-gray-200 fx-active:dark:ring-gray-700/60 fx-active:shadow"
                    id="preview">
                    <span class="iconify size-3 ph--eye opacity-80"></span>
                    <span class="hidden sm:flex">Preview</span>
                </x-ui.tabs.trigger>
                <x-ui.tabs.trigger unStyled wrapper-class="flex"
                    class="relative flex items-center gap-1 disabled:cursor-not-allowed disabled:opacity-80 fx-active:text-fg-title outline-none focus:outline-0 focus:outline-transparent focus-visible:outline focus-visible:outline-primary px-2.5 py-1 rounded-(--global-main-radius) fx-active:bg-white fx-active:dark:bg-gray-800 ring-1 ring-transparent fx-active:ring-gray-200 fx-active:dark:ring-gray-700/60 fx-active:shadow"
                    id="code">
                    <span class="iconify size-3 ph--code opacity-80"></span>
                    <span class="hidden sm:flex">Code</span>
                </x-ui.tabs.trigger>
            </x-ui.tabs.list>
            <div class="flex-1 flex jystify-start items-center gap-0.5 border-l border-border pl-2">
                <x-ui.link href="{{ $preview }}" target="_blank" aria-label="Open in new tab"
                    title="Open in new tab"
                    class="btn btn-ghost btn-ghost-gray rounded-ui px-2 py-1 h-7 flex text-sm ease-linear duration-200">
                    <span aria-hidden="true" class="flex iconify ph--arrows-out text-sm"></span>
                </x-ui.link>
                <button data-refresh-iframe
                    class="btn btn-ghost btn-ghost-gray rounded-ui px-2 py-1 h-7 flex text-sm ease-linear duration-200">
                    <span aria-hidden="true" class="flex iconify ph--arrows-clockwise text-sm"></span>
                </button>
            </div>
            <div class="flex items-center min-w-max text-fg">
                <div class="hidden sm:flex">
                    @php
                        $command = "php artisan flexi:add {$title}";
                        $command_install = "php artisan flexi:add @club/{$title}";
                    @endphp
                    <x-ui.button x-copy-command size="none" variant="none" data-command="{{ $command_install }}"
                        class="bg-bg shadow h-8 pl-2 pr-3 text-xs border border-border/50 rounded-md flex justify-center items-center cursor-pointer hover:bg-bg-surface">
                        <span aria-hidden="true" class="flex iconify ph--terminal"></span>
                        <span class="text-fg-muted ml-1">{{ $command }}</span>
                    </x-ui.button>
                </div>
            </div>
        </x-ui.tabs.list-wrapper>
        <x-ui.tabs.panel-wrapper data-ui-previewbox
            class="bg-bg h-max overflow-hidden flex items-center justify-center ring ring-border-card rounded-ui w-full relative group flex-1">
            <x-ui.tabs.panel id="preview" show-as-grid active class="size-full max-h-180">
                <livewire:v-ui.preview-block :is-full-screen="$isFullScreen" url="{{ $preview }}" />
            </x-ui.tabs.panel>
            <x-ui.tabs.panel id="code" show-as-grid class="size-full max-h-280">
                {{-- <livewire:v-ui.preview-block url="{{ $preview }}" /> --}}
            </x-ui.tabs.panel>
        </x-ui.tabs.panel-wrapper>
    </x-ui.tabs>
</article>
