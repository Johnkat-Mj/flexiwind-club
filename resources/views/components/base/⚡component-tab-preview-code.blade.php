<?php

use Livewire\Component;

new class extends Component {
    public string $filePath = '';
    public string $component = '';
    public string $pathShow = '';

    public bool $isLivewire = false;
    public string $componentPreview = '';
    public bool $noInTabs = false;

    public function mount(string $component = '', $noInTabs = false)
    {
        $this->component = $component;
        $this->loadComponentCode();
        $this->noInTabs = $noInTabs;
    }

    protected function loadComponentCode()
    {
        if (empty($this->component)) {
            return;
        }

        $componentPath = str_replace('.', '/', $this->component);
        $this->filePath = resource_path("views/{$componentPath}.blade.php");

        $previewcomponentPath = str_replace('/', '.', $this->component);
        if (str_starts_with($previewcomponentPath, 'livewire.')) {
            $this->isLivewire = true;
        }

        $this->componentPreview = substr($previewcomponentPath, 11);
    }
};
?>


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
        <livewire:base.view-component-code :file-path="$filePath" />
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
            <livewire:base.view-component-code :file-path="$filePath" />
        </x-docs.tab-panel>
    </x-docs.docs-tab>
@endif
