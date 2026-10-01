<div class="flex flex-col gap-1.5 max-w-xs w-full">
    <x-club.select.trigger select-id="select-demo-searchable">
        <x-club.select.placeholder class="text-sm text-start">Choisir un framework</x-club.select.placeholder>
    </x-club.select.trigger>
    <x-club.select.box-selected-value select-id="select-demo-searchable" class="text-foreground text-sm" />
</div>

<x-club.select.input-value select-id="select-demo-searchable" name="framework" />

<x-club.select id="select-demo-searchable">
    <x-club.select.input-search placeholder="Rechercher…" />
    <x-club.select.list-box>
        <x-club.select.item value="astro">Astro</x-club.select.item>
        <x-club.select.item value="laravel">Laravel</x-club.select.item>
        <x-club.select.item value="livewire">Livewire</x-club.select.item>
        <x-club.select.item value="vue">Vue</x-club.select.item>
        <x-club.select.item value="svelte">Svelte</x-club.select.item>
    </x-club.select.list-box>
    <x-club.select.template-empty>
        <div class="px-3 py-2 text-sm text-muted-foreground">
            Aucun résultat pour "<x-club.select.empty-string />"
        </div>
    </x-club.select.template-empty>
</x-club.select>
