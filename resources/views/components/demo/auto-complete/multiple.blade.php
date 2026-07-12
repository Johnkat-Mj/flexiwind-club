<div class="flex flex-col gap-1.5 max-w-xs w-full">
    <x-club.autocomplete.trigger auto-complete-id="autocomplete-demo-multiple" />
    <x-club.select.box-selected-value select-id="autocomplete-demo-multiple" class="text-fg text-sm">
        <x-club.select.placeholder class="text-sm">No owner selected</x-club.select.placeholder>
    </x-club.select.box-selected-value>
</div>

<x-club.autocomplete id="autocomplete-demo-multiple" multiple>
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
</x-club.autocomplete>
