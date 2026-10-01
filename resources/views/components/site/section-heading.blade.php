{{--
    Titre de section du site : pastille, titre en deux tons, texte d'appui.
    `$title` est la partie foncée, `$muted` la suite en gris.
--}}
@props(['icon' => null, 'eyebrow' => null, 'title', 'muted' => null, 'center' => true, 'as' => 'h2'])

<div {{ $attributes->class(['flex flex-col', 'items-center text-center' => $center, 'items-start' => ! $center]) }}>
    @if ($eyebrow)
        <x-site.eyebrow :icon="$icon">{{ $eyebrow }}</x-site.eyebrow>
    @endif
    <{{ $as }} @class([
        'font-display mt-4 max-w-160 text-4xl/tight font-semibold tracking-[-0.035em] text-balance text-title-foreground sm:text-5xl/[1.1]',
        'mx-auto' => $center,
    ])>
        {{ $title }}@if ($muted)
            <span class="text-subtitle">{{ $muted }}</span>
        @endif
    </{{ $as }}>
    @if ($slot->isNotEmpty())
        <p @class(['mt-4 max-w-130 text-base/relaxed text-pretty text-muted-foreground', 'mx-auto' => $center])>
            {{ $slot }}
        </p>
    @endif
</div>
