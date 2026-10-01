<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Models\User;
use Flexiwind\Docs\Tier;
use Illuminate\Support\Facades\Blade;

function subscribe(User $user, string $planKey = 'solo-lifetime'): void
{
    app(Checkout::class)->markPaid(
        app(Checkout::class)->start($user, Plan::find($planKey)),
        'sim_test',
    );
}

it('reads the tier from the subscription, not from config', function (): void {
    config()->set('flexiwind-docs.tier', 'pro');

    expect(Tier::current())->toBe(Tier::Free);

    $user = User::factory()->create();
    subscribe($user);
    $this->actingAs($user->fresh());

    expect(Tier::current())->toBe(Tier::Pro);
});

/** Un aperçu d'exemple pro, tel qu'une page de doc l'affiche. */
function proExamplePreview(): string
{
    return Blade::render('<x-fw-docs::preview example="select/default" tier="pro" />');
}

it('shows a pro example but locks its source for a visitor without a subscription', function (): void {
    expect(proExamplePreview())
        ->toContain('Source reserved for Pro')
        ->not->toContain('Unlock with Pro</span>');
});

it('shows the source of the same example to a subscriber', function (): void {
    $user = User::factory()->create();
    subscribe($user);

    $this->actingAs($user->fresh());

    expect(proExamplePreview())->not->toContain('Source reserved for Pro');
});

it('locks the code tab of a pro block for a visitor without a subscription', function (): void {
    $this->get('/blocks/application/settings')
        ->assertOk()
        ->assertSee('Source reserved for Pro', false);
});

it('opens the code tab of the same block to a subscriber', function (): void {
    $user = User::factory()->create();
    subscribe($user);

    $this->actingAs($user->fresh())
        ->get('/blocks/application/settings')
        ->assertOk()
        ->assertDontSee('Source reserved for Pro', false);
});

it('never locks a free component', function (): void {
    $this->get('/components/button')
        ->assertOk()
        ->assertDontSee('Source reserved for Pro', false);
});

it('stops granting pro the moment the subscription expires', function (): void {
    $user = User::factory()->create();
    subscribe($user, 'solo-annual');

    $user->fresh()->activeSubscription()->forceFill(['ends_at' => now()->subDay()])->save();

    $this->actingAs(User::find($user->id));

    expect(proExamplePreview())->toContain('Source reserved for Pro');
});
