<x-club.autocomplete.trigger auto-complete-id="autocomplete-demo" class="max-w-xs" />
<x-club.autocomplete id="autocomplete-demo">
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
    </x-club.select.list-box>
    <x-club.select.template-empty>
        <div class="px-3 py-2 text-sm text-fg-muted">
            No data found for "<x-club.select.empty-string />"
        </div>
    </x-club.select.template-empty>
</x-club.autocomplete>
