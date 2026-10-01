@props(['totals'])

<x-site.section id="pricing">
    <x-site.container class="py-20 lg:py-28">
        <x-site.section-heading icon="ph--tag" eyebrow="Pricing" title="Pay once or yearly." muted="Keep the code forever.">
            Whatever you install stays in your repository — even if you stop paying. Pro only decides what you can pull next.
        </x-site.section-heading>
        <x-landing.pricing-plans :totals="$totals" class="mt-14" />
        <p class="mt-8 text-center text-sm text-muted-foreground">
            One account per seat. Each person signs in with their own email and manages their own CLI tokens.
        </p>
    </x-site.container>
</x-site.section>
