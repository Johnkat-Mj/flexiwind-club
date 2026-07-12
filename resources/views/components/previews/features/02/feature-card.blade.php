@props(['icon', 'title', 'description'])
<div class="flex flex-col items-center text-center space-y-4">
    <span class="size-10 d-flex-place-center rounded-ui flex ui-soft ui-soft-gray">
        <x-ui.icon name="{{ $icon }}" size="md" />
    </span>
    <h3 class="font-semibold text-xl text-fg-subtitle">
        {{ $title }}
    </h3>
    <x-ui.text class="text-sm mx-auto max-w-md">
        {{ $description }}
    </x-ui.text>
</div>
