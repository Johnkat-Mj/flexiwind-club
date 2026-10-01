{{-- Code surligné par Shiki, avec numéros de ligne en CSS. --}}
@props(['code', 'lang' => 'blade'])

<div {{ $attributes->class('code-lines min-h-0 flex-1 overflow-auto px-4 pt-4 pb-6 font-mono text-[12.5px]/5') }}>
    {!! App\Support\HighlightedCodeRenderer::render(rtrim($code), $lang) !!}
</div>
