<div class="flex flex-col gap-1.5 max-w-xs w-full">
    <x-club.select.trigger select-id="select-demo-multiple">
        <x-club.select.placeholder class="text-sm text-start">Select a user</x-club.select.placeholder>
    </x-club.select.trigger>
    <x-club.select.box-selected-value select-id="select-demo-multiple" class="text-fg text-sm" />
</div>

<x-club.select id="select-demo-multiple" multiple>
    <x-club.select.list-box>
        <x-club.select.item value="Hello">
            John Doe
        </x-club.select.item>
        <x-club.select.item value="jack">
            Jack Doe
        </x-club.select.item>
        <x-club.select.item value="George">
            George Doe
        </x-club.select.item>
        <x-club.select.item value="George_K">
            George Doe K
        </x-club.select.item>
        <x-club.select.item value="George_R">
            George Doe R
        </x-club.select.item>
    </x-club.select.list-box>
    <x-club.select.template-empty>
        <div class="px-3 py-2 text-sm text-fg-muted">
            No data found for "<x-club.select.empty-string />"
        </div>
    </x-club.select.template-empty>
</x-club.select>
