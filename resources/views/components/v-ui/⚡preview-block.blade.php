<?php

use Livewire\Component;

new class extends Component
{
    public string $url = '';

    public bool $isFullScreen = false;

    public function mount(string $url, bool $isFullScreen)
    {
        $this->url = $url;
        $this->isFullScreen = $isFullScreen;
    }
};
?>

<div class="w-full h-full bg-bg duration-300 ease-linear  ui-preview-frame
    flex items-center justify-center relative 
      overflow-hidden "
    x-data="{ frameIsLoading: true }">
    <div x-show="frameIsLoading" class="absolute inset-0 flex items-center justify-center">
        <x-ui.skeleton radius-none class="size-full rounded-ui" />
    </div>

    <iframe loading="lazy" src="{{ $url }}" x-bind:data-frame-loading="frameIsLoading"
        x-on:load="frameIsLoading = false" x-preview-frame
        style="--frame-height:200px;"
        class="
            w-full  max-h-full data-[frame-loading=true]:invisible data-[frame-loading=true]:opacity-0 overflow-hidden
            {{ $isFullScreen ? 'h-[calc(100vh-6rem)] xl:h-170' :'h-(--frame-height)'}}
        "></iframe>
</div>
