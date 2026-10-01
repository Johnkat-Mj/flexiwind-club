<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Models\Subscription;
use App\Models\User;

it('exposes exactly the three plans of the catalogue', function (): void {
    expect(array_keys(Plan::all()))
        ->toBe(['solo-annual', 'solo-lifetime', 'team-lifetime']);

    expect(Plan::find('solo-annual')->seats)->toBe(1);
    expect(Plan::find('solo-lifetime')->isLifetime())->toBeTrue();
    expect(Plan::find('team-lifetime')->seats)->toBe(5);
});

it('does not resolve a plan that is not in the catalogue', function (): void {
    expect(Plan::find('free-forever'))->toBeNull();
    expect(Plan::find(null))->toBeNull();
});

it('reads the price from the catalogue, never from the caller', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $subscription = $checkout->start($user, Plan::find('solo-lifetime'));

    // Un attaquant qui aurait réussi à écrire 0 en base avant le paiement
    // voit quand même le montant du catalogue à l'activation.
    $subscription->forceFill(['amount_cents' => 0])->save();

    $checkout->markPaid($subscription, 'sim_test');

    expect($subscription->fresh()->amount_cents)->toBe(Plan::find('solo-lifetime')->priceCents);
});

it('activates a lifetime plan with no end date and seats the owner', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $subscription = $checkout->markPaid(
        $checkout->start($user, Plan::find('solo-lifetime')),
        'sim_test',
    );

    expect($subscription->status)->toBe(Subscription::STATUS_ACTIVE)
        ->and($subscription->ends_at)->toBeNull()
        ->and($subscription->members()->count())->toBe(1)
        ->and($user->fresh()->hasProAccess())->toBeTrue();
});

it('gives an annual plan a one-year end date', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $subscription = $checkout->markPaid(
        $checkout->start($user, Plan::find('solo-annual')),
        'sim_test',
    );

    expect($subscription->ends_at->toDateString())->toBe(now()->addYear()->toDateString());
});

it('ignores a payment confirmation replayed twice', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $subscription = $checkout->markPaid($checkout->start($user, Plan::find('solo-annual')), 'sim_test');
    $firstEnd = $subscription->ends_at;

    $checkout->markPaid($subscription, 'sim_test');

    expect($subscription->fresh()->ends_at->eq($firstEnd))->toBeTrue()
        ->and(Subscription::count())->toBe(1);
});

it('refuses to open a second subscription for an account that already has one', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $checkout->markPaid($checkout->start($user, Plan::find('solo-lifetime')), 'sim_test');

    expect(fn () => $checkout->start($user->fresh(), Plan::find('solo-annual')))
        ->toThrow(RuntimeException::class);
});

it('treats an expired subscription as no access', function (): void {
    $user = User::factory()->create();
    $checkout = app(Checkout::class);

    $subscription = $checkout->markPaid($checkout->start($user, Plan::find('solo-annual')), 'sim_test');
    $subscription->forceFill(['ends_at' => now()->subDay()])->save();

    expect($user->fresh()->hasProAccess())->toBeFalse();
});

it('treats an unpaid subscription as no access', function (): void {
    $user = User::factory()->create();

    app(Checkout::class)->start($user, Plan::find('solo-lifetime'));

    expect($user->fresh()->hasProAccess())->toBeFalse();
});

it('404s on a checkout page for a plan that does not exist', function (): void {
    $this->actingAs(User::factory()->create())
        ->get('/checkout/free-forever')
        ->assertNotFound();
});

it('sends a guest to the login page before checkout', function (): void {
    $this->get('/checkout/solo-lifetime')->assertRedirect(route('login'));
});

it('refuses the simulated activation when simulation is off', function (): void {
    config()->set('billing.simulate', false);

    Livewire::actingAs(User::factory()->create())
        ->test('pages::checkout', ['plan' => 'solo-lifetime'])
        ->call('confirm')
        ->assertForbidden();

    expect(Subscription::count())->toBe(0);
});

it('activates the subscription from the checkout page when simulation is on', function (): void {
    config()->set('billing.simulate', true);
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::checkout', ['plan' => 'team-lifetime'])
        ->call('confirm')
        ->assertRedirect(route('account.subscription'));

    expect($user->fresh()->hasProAccess())->toBeTrue()
        ->and(Subscription::firstOrFail()->seats)->toBe(5);
});
