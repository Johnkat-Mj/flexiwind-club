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
        ['text' => 'Preview', 'icon' => 'ph--eye', 'value' => 'Preview'],
        ['text' => 'Code', 'icon' => 'ph--code', 'value' => 'Code'],
    ]"
        triggersClass="px-2.5 py-1 border-b-2 border-transparent fx-active:border-fg-title fx-active:text-fg-title"
        tabListContainer="" tabList="mb-2 pt-2 border-b border-border-strong/60 relative text-fg-muted">
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
            class="overflow-hidden bg-(--astro-code-color-background) rounded-ui">
            <x-base.view-component-code :file-path="$filePath" />
        </x-docs.tab-panel>
    </x-docs.docs-tab>
@endif
