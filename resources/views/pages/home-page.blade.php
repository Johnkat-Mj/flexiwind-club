@php
    $totals = App\Support\BlockCatalog::totals();
@endphp

<x-layouts::site>
    <main>
        <x-landing.hero />
        <x-landing.showcase :block-count="$totals['total']" />
        <x-landing.stats :block-count="$totals['total']" :free-count="$totals['free']" />
        <x-landing.why />
        <x-landing.library :totals="$totals" />
        <x-landing.compare :totals="$totals" />
        <x-landing.pricing :totals="$totals" />
        <x-landing.faq />
        <x-landing.final-cta />
    </main>
</x-layouts::site>
