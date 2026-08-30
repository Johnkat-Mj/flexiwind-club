@props(['text' => null, 'noWrap' => false])

<code class="inline-code inline {{ $noWrap ? 'text-nowrap' : 'text-wrap' }}">{{ $text ?? $slot }}</code>
