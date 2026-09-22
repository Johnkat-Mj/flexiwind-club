<x-layouts::base>
    <x-atoms.global-lines />
    <x-layouts::site-header />
    {{ $slot }}
    <x-layouts::site-footer />
    <x-blocks.modal-search />
</x-layouts::base>
