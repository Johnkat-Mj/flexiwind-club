<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component
{
    /**
     * #[Locked] : la clé de plan vient de l'URL et ne peut plus bouger. Même
     * si elle bougeait, Plan::find() la revalide contre le catalogue à chaque
     * rendu — un plan inventé n'existe pas.
     */
    #[Locked]
    public string $planKey = '';

    public ?string $error = null;

    public function mount(string $plan): void
    {
        abort_if(Plan::find($plan) === null, 404);

        $this->planKey = $plan;
    }

    public function confirm(Checkout $checkout): void
    {
        // Le paiement simulé n'existe qu'en dehors de la production. En
        // production, cette action se termine ici : il n'y a aucun chemin de
        // code qui active un abonnement sans le prestataire.
        abort_unless(config('billing.simulate'), 403);

        $plan = Plan::find($this->planKey);
        abort_if($plan === null, 404);

        try {
            $subscription = $checkout->start(auth()->user(), $plan);
            $checkout->markPaid($subscription, $checkout->simulatedReference());
        } catch (\RuntimeException $e) {
            $this->error = $e->getMessage();

            return;
        }

        session()->flash('status.sent', 'Subscription active. Generate a token to use the CLI.');

        $this->redirectRoute('account.subscription', navigate: true);
    }

    public function with(): array
    {
        return [
            'plan' => Plan::find($this->planKey),
            'alreadySubscribed' => auth()->user()->hasProAccess(),
            'canSimulate' => (bool) config('billing.simulate'),
        ];
    }
};
?>

<main class="flex-1">
    <x-atoms.container class="py-16 lg:py-24">
        <div class="mx-auto max-w-lg">
            <a href="{{ route('pricing') }}" wire:navigate
                class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
                <span aria-hidden="true" class="iconify ph--arrow-left text-xs"></span>
                Back to plans
            </a>

            <h1 class="mt-4 text-2xl font-semibold text-title-foreground">Confirm your plan</h1>

            @if ($error)
                <x-ui.alert variant="soft" intent="destructive" size="sm" class="mt-5 text-sm">{{ $error }}</x-ui.alert>
            @endif

            <section class="mt-6 rounded-ui border border-border-card bg-background">
                <div class="flex items-start justify-between gap-4 border-b border-border-card p-5">
                    <div>
                        <p class="font-medium text-title-foreground">{{ $plan->name }}</p>
                        <p class="mt-1 text-sm text-muted-foreground">{{ $plan->tagline }}</p>
                    </div>
                    <div class="text-right whitespace-nowrap">
                        <p class="text-xl font-semibold text-title-foreground">{{ $plan->formattedPrice() }}</p>
                        <p class="text-xs text-muted-foreground">{{ $plan->billingLabel }}</p>
                    </div>
                </div>

                <dl class="divide-y divide-border-card text-sm">
                    <div class="flex justify-between px-5 py-3">
                        <dt class="text-muted-foreground">Seats</dt>
                        <dd class="text-foreground">{{ $plan->seats }}</dd>
                    </div>
                    <div class="flex justify-between px-5 py-3">
                        <dt class="text-muted-foreground">Access</dt>
                        <dd class="text-foreground">{{ $plan->isLifetime() ? 'Lifetime' : 'One year' }}</dd>
                    </div>
                    <div class="flex justify-between px-5 py-3">
                        <dt class="text-muted-foreground">Billed to</dt>
                        <dd class="text-foreground">{{ auth()->user()->email }}</dd>
                    </div>
                </dl>

                <div class="p-5">
                    @if ($alreadySubscribed)
                        <x-ui.alert variant="soft" intent="gray" size="sm" class="text-sm">
                            This account already has an active subscription.
                            <a href="{{ route('account.subscription') }}" wire:navigate class="underline">See it</a>.
                        </x-ui.alert>
                    @elseif ($canSimulate)
                        <x-ui.button wire:click="confirm" variant="solid" intent="primary" class="w-full">
                            <span wire:loading.remove wire:target="confirm">Activate — simulated payment</span>
                            <span wire:loading wire:target="confirm">Activating…</span>
                        </x-ui.button>
                        <p class="mt-3 text-center text-xs text-muted-foreground">
                            No card is charged. This shortcut exists only outside production, while the payment
                            provider is being wired up.
                        </p>
                    @else
                        <x-ui.alert variant="soft" intent="gray" size="sm" class="text-sm">
                            Checkout is not open yet. The payment provider is being connected.
                        </x-ui.alert>
                    @endif
                </div>
            </section>
        </div>
    </x-atoms.container>
</main>
