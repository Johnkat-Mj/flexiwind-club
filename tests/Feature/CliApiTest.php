<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Models\ApiToken;
use App\Models\User;

function activeToken(bool $pro = false): string
{
    $user = User::factory()->create();

    if ($pro) {
        app(Checkout::class)->markPaid(
            app(Checkout::class)->start($user, Plan::find('solo-lifetime')),
            'sim_test',
        );
    }

    return ApiToken::issue($user->fresh(), 'cli')->plainText;
}

it('refuses a call with no token', function (): void {
    $this->getJson('/api/v1/me')->assertUnauthorized();
});

it('refuses a call with an unknown token', function (): void {
    $this->withToken('fx_'.str_repeat('z', 48))
        ->getJson('/api/v1/me')
        ->assertUnauthorized();
});

it('refuses a call with a revoked token', function (): void {
    $secret = activeToken(pro: true);
    ApiToken::findActive($secret)->revoke();

    $this->withToken($secret)->getJson('/api/v1/me')->assertUnauthorized();
});

it('reports the tier of the account behind the token', function (): void {
    $this->withToken(activeToken())->getJson('/api/v1/me')
        ->assertOk()
        ->assertJsonPath('tier', 'free');

    $this->withToken(activeToken(pro: true))->getJson('/api/v1/me')
        ->assertOk()
        ->assertJsonPath('tier', 'pro');
});

it('records when a token was last used', function (): void {
    $secret = activeToken();
    expect(ApiToken::findActive($secret)->last_used_at)->toBeNull();

    $this->withToken($secret)->getJson('/api/v1/me');

    expect(ApiToken::findActive($secret)->last_used_at)->not->toBeNull();
});

it('serves a free block to any valid token', function (): void {
    $this->withToken(activeToken())
        ->getJson('/api/v1/registry/header01')
        ->assertOk();
});

it('refuses a pro block to a token with no active subscription', function (): void {
    $this->withToken(activeToken())
        ->getJson('/api/v1/registry/@fx/login01')
        ->assertForbidden()
        ->assertJsonPath('upgrade_url', url('/pricing'));
});

it('serves a pro block to a subscriber', function (): void {
    $this->withToken(activeToken(pro: true))
        ->getJson('/api/v1/registry/@fx/login01')
        ->assertOk();
});

it('stops serving pro blocks once the subscription expires', function (): void {
    $secret = activeToken(pro: true);
    ApiToken::findActive($secret)->user->activeSubscription()
        ->forceFill(['ends_at' => now()->subDay()])->save();

    $this->withToken($secret)
        ->getJson('/api/v1/registry/@fx/login01')
        ->assertForbidden();
});

it('rejects a name that tries to walk out of the registry', function (string $name): void {
    $this->withToken(activeToken(pro: true))
        ->getJson('/api/v1/registry/'.$name)
        ->assertNotFound();
})->with(['../../.env', '..%2F..%2F.env', 'a/b']);
