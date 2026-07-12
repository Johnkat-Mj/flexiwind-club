@props([
    'component' => '',
    'noInTabs' => false,
])

@php
    $filePath = '';
    $isLivewire = false;
    $componentPreview = '';

    if ($component !== '') {
        $componentPath = str_replace('.', '/', $component);
        $filePath = resource_path("views/{$componentPath}.blade.php");

        $previewComponentPath = str_replace('/', '.', $component);

        if (str_starts_with($previewComponentPath, 'livewire.')) {
            $isLivewire = true;
        }

        $componentPreview = substr($previewComponentPath, 11);
    }
@endphp

@if ($noInTabs)
    <div
        class="grid w-full gap-1 p-4 md:p-10 bg-bg border border-border-input rounded-ui my-5 first:mt-0">
        <div data-gen-ignore
            class="flex justify-center min-h-max">
            @if ($isLivewire)
                <span>
                    Sorry can't resolve this
                </span>
            @else
                <x-dynamic-component :component="$componentPreview" />
            @endif
        </div>
        <x-base.view-component-code :file-path="$filePath" />
    </div>
@else
    <x-docs.docs-tab :values="[
        ['text' => 'Preview', 'icon' => 'ph--eye s', 'value' => 'Preview'],
        ['text' => 'Code', 'icon' => 'ph--code', 'value' => 'Code'],
    ]"
        triggersClass="relative flex gap-1 items-center disabled:cursor-not-allowed disabled:opacity-80 fx-active:text-fg-title outline-none focus:outline-0 focus:outline-transparent focus-visible:outline focus-visible:outline-primary px-2.5 py-1 rounded-ui fx-active:bg-white fx-active:dark:bg-gray-800 ring-1 ring-transparent fx-active:ring-gray-200 fx-active:dark:ring-gray-700/60 fx-active:shadow"
        tabListContainer="w-full flex justify-between items-center gap-2 h-max pb-0.5 pt-px px-3.5 relative" tabList="flex items-center gap-0.5 text-sm text-fg-muted"
        docPanelClass="pt-2.5"
        iconClass="opacity-80 size-3"
        >
        <x-docs.tab-panel value="Preview"
            class="bg-bg border border-border-input rounded-ui items-center justify-center min-h-60 lg:min-h-80"
            active>
            <div data-gen-ignore
                class="size-full flex items-center justify-center p-4 md:p-10">
                @if ($isLivewire)
                    <span>
                        Sorry can't resolve this
                    </span>
                @else
                    <x-dynamic-component :component="$componentPreview" />
                @endif
            </div>
        </x-docs.tab-panel>
        <x-docs.tab-panel value="Code" show-with-grid
            class="overflow-hidden border border-gray-200 dark:border-gray-800/60 bg-gray-800 dark:bg-gray-900/50 grid text-gray-300 rounded-ui">
            
            <x-base.view-component-code :file-path="$filePath" />
        </x-docs.tab-panel>
    </x-docs.docs-tab>
@endif
