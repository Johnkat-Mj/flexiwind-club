{{--
    Une bande du site : filet en bas, croix aux intersections avec les rails,
    grille estompée en option. Le contenu va dans <x-site.container>.
--}}
@props(['as' => 'section', 'grid' => false, 'pattern' => true])

<{{ $as }} {{ $attributes->class('relative border-b border-border') }}>
    @if ($grid)
        <div aria-hidden="true"
            class="bg-grid pointer-events-none absolute inset-y-0 left-1/2 w-full max-w-300 -translate-x-1/2"></div>
    @endif
    {{ $slot }}
    @if ($pattern)
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -bottom-1.5 z-10 px-2 lg:px-0">
            <div class="relative mx-auto h-2.75 w-full max-w-300">
                <x-site.cross class="-left-1.25" />
                <x-site.cross class="-right-1.25" />
            </div>
        </div>
    @endif
    </{{ $as }}>
