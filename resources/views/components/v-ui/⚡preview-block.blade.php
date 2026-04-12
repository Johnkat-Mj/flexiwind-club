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

<div data-preview-box style="--frame-height:200px;" class="w-full bg-bg duration-300 ease-linear 
    grid relative 
      overflow-hidden
       {{ $isFullScreen ? 'h-[max(calc(100vh-6rem),var(--frame-height))] xl:h-[max(42.5rem,var(--frame-height))]' :'h-(--frame-height)'}}
      "
    x-data="{ frameIsLoading: true }"
    
    >
    <div x-show="frameIsLoading" class="absolute inset-0 flex items-center justify-center">
        <x-ui.skeleton radius-none class="size-full rounded-ui" />
    </div>

    <iframe loading="lazy" src="{{ $url }}" x-bind:data-frame-loading="frameIsLoading"
        x-on:load="frameIsLoading = false" x-preview-frame
        
        class="
            w-full data-[frame-loading=true]:invisible data-[frame-loading=true]:opacity-0 overflow-hidden h-full
        "></iframe>
</div>
