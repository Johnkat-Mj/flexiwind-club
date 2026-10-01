<x-club.select.trigger select-id="demo-select-basic" placeholder="Choose a framework" class="w-full max-w-xs">
    <x-club.select.box-selected-value class="text-foreground text-sm" placeholder="Select a framework"/>
</x-club.select.trigger>

<x-club.select.input-value select-id="demo-select-basic" name="framework" />
<x-club.select id="demo-select-basic">
    <x-club.select.list-box>
        <x-club.select.item value="astro">
            Astro
        </x-club.select.item>
        <x-club.select.item value="vue">
            Vue
        </x-club.select.item>
        <x-club.select.item value="laravel">
            Laravel
        </x-club.select.item>
    </x-club.select.list-box>
</x-club.select>
