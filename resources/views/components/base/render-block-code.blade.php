@props([
    'code' => '',
    'lang' => 'php',
    'lines' => [],
])

@php
    $highlightedCode = \App\Support\HighlightedCodeRenderer::render($code, $lang, $lines);
@endphp

<figure data-code-snippet role="region" aria-label="codeblock region" class="w-full bg-[#07090]">
    @if ($highlightedCode !== '')
        {!! $highlightedCode !!}
    @else
        <div class="text-gray-500">No code to display</div>
    @endif
</figure>
