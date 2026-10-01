<?php

use App\Billing\Plan;
use App\Support\BlockCatalog;
use Livewire\Component;

new class extends Component
{
    public function with(): array
    {
        return [
            'plans' => Plan::all(),
            'current' => auth()->user()?->activeSubscription(),
            'totals' => BlockCatalog::totals(),
        ];
    }
};
?>

<main class="flex-1">
    <x-site.page-header icon="ph--tag" eyebrow="Pricing" title="Pay once or yearly." muted="Keep the code forever." center>
        The free components stay free, forever. Pro adds the pro components, the pro blocks and the source behind
        every locked example — yours to copy into your projects.
    </x-site.page-header>

    <x-site.section>
        <x-site.container class="py-12 lg:py-16">
            @if ($current)
                <div class="mx-auto mb-8 max-w-md">
                    <x-ui.alert variant="soft" intent="success" size="sm" class="text-center text-sm">
                        You're already on {{ $current->planName() }}.
                        <a href="{{ route('account.subscription') }}" wire:navigate class="underline">Manage it</a>.
                    </x-ui.alert>
                </div>
            @endif

            <x-landing.pricing-plans :totals="$totals" />

            <p class="mt-8 text-center text-sm text-muted-foreground">
                One account per seat. Each person signs in with their own email and manages their own CLI tokens.
            </p>
        </x-site.container>
    </x-site.section>

    <x-landing.compare :totals="$totals" />
    <x-landing.faq />
</main>
