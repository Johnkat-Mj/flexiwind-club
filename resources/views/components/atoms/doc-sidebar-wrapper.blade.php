@persist('sidebar')
    {{--
        flex-1 min-h-0 : sans min-h-0, un élément flex ne descend jamais sous la
        taille de son contenu (min-height: auto), donc le conteneur de scroll
        prend toute la hauteur du contenu et overflow-y-auto ne sert à rien.
        La sidebar fusionnée (14 groupes, 68 pages) dépasse largement l'écran :
        c'est ce qui l'empêchait de défiler.
    --}}
    <x-atoms.scrollable-y class="w-full flex-1 min-h-0" wire:navigate:scroll>
        {{ $slot }}
    </x-atoms.scrollable-y>
@endpersist
