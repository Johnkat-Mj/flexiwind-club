@props(['icon', 'title', 'description'])
<div class="flex flex-col justify-center md:justify-start">
    <span class="size-9 d-flex-place-center rounded-ui flex ui-soft ui-soft-gray">
        <x-ui.icon name="{{ $icon }}"  />
    </span>
    <h3 class="flex font-semibold text-lg text-title-foreground  capitalize mt-4">
        {{ $title }}
    </h3>
    <x-ui.text intent="body" class="mt-2 text-sm">
        {{ $description }}
    </x-ui.text>
</div>
