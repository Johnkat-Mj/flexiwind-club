{{--
    Les cartes de prix : l'offre gratuite puis chaque plan de config/plans.php.
    Le bouton suit l'état du visiteur (invité, connecté, déjà abonné).
--}}
@props(['totals'])

@php
    $plans = App\Billing\Plan::all();
    $current = auth()->user()?->activeSubscription();
@endphp

<div {{ $attributes->class('grid gap-4 md:grid-cols-2 xl:grid-cols-4') }}>
    <x-landing.price-card name="Open source" price="€0" billing="forever"
        tagline="The foundation: primitives, free blocks and the full documentation."
        :features="['Every UI primitive', $totals['free'].' free blocks', 'The full documentation', 'The flexi CLI']">
        <x-ui.button href="/docs/introduction" wire:navigate variant="outline" intent="gray"
            class="h-10.5 w-full justify-center rounded-[10px] font-medium text-title-foreground">Read the docs</x-ui.button>
    </x-landing.price-card>

    @foreach ($plans as $plan)
        <x-landing.price-card :name="$plan->name" :price="$plan->formattedPrice()" :billing="$plan->billingLabel"
            :tagline="$plan->tagline" :features="$plan->features" :featured="$plan->featured">
            @if ($current)
                <x-ui.button variant="soft" intent="gray" class="h-10.5 w-full justify-center rounded-[10px]" disabled>
                    Already subscribed
                </x-ui.button>
            @else
                <x-ui.button :href="auth()->check() ? route('checkout.show', ['plan' => $plan->key]) : route('login', ['plan' => $plan->key])"
                    wire:navigate :variant="$plan->featured ? 'solid' : 'outline'" :intent="$plan->featured ? 'primary' : 'gray'"
                    class="h-10.5 w-full justify-center rounded-[10px] font-medium {{ $plan->featured ? '' : 'text-title-foreground' }}">
                    Get {{ $plan->name }}
                </x-ui.button>
            @endif
        </x-landing.price-card>
    @endforeach
</div>
