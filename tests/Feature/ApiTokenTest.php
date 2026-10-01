<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Models\ApiToken;
use App\Models\User;

it('stores only the hash and shows the secret once', function (): void {
    $user = User::factory()->create();

    $token = ApiToken::issue($user, 'laptop');

    expect($token->plainText)->toStartWith('fx_')
        ->and($token->token_hash)->toBe(hash('sha256', $token->plainText))
        ->and($token->getAttributes())->not->toHaveKey('plainText');

    // Rechargé depuis la base, le secret a disparu.
    expect($token->fresh()->plainText)->toBeNull();
});

it('finds an active token from its secret and not from its hash', function (): void {
    $user = User::factory()->create();
    $token = ApiToken::issue($user, 'laptop');

    expect(ApiToken::findActive($token->plainText)?->id)->toBe($token->id)
        ->and(ApiToken::findActive($token->token_hash))->toBeNull()
        ->and(ApiToken::findActive('fx_'.str_repeat('x', 48)))->toBeNull();
});

it('stops finding a revoked token', function (): void {
    $token = ApiToken::issue(User::factory()->create(), 'laptop');
    $secret = $token->plainText;

    $token->revoke();

    expect(ApiToken::findActive($secret))->toBeNull();
});

it('creates a token from the account page', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('profile::tokens')
        ->set('name', 'CI runner')
        ->call('create')
        ->assertSet('name', '')
        ->assertSet('justCreated', fn (?string $s) => str_starts_with((string) $s, 'fx_'));

    expect($user->apiTokens()->count())->toBe(1);
});

it('refuses to revoke a token that belongs to someone else', function (): void {
    $mine = User::factory()->create();
    $theirs = User::factory()->create();
    $token = ApiToken::issue($theirs, 'their laptop');

    Livewire::actingAs($mine)
        ->test('profile::tokens')
        ->call('askRevoke', $token->id)
        ->assertSet('confirmingRevoke', null)
        // Même en forçant la propriété depuis le navigateur.
        ->set('confirmingRevoke', $token->id)
        ->call('revoke');

    expect($token->fresh()->isRevoked())->toBeFalse();
});

it('revokes one of my tokens after confirmation', function (): void {
    $user = User::factory()->create();
    $token = ApiToken::issue($user, 'laptop');

    Livewire::actingAs($user)
        ->test('profile::tokens')
        ->call('askRevoke', $token->id)
        ->assertSet('confirmingRevoke', $token->id)
        ->assertSee('Revoke “laptop”?')
        ->call('revoke')
        ->assertSet('confirmingRevoke', null);

    expect($token->fresh()->isRevoked())->toBeTrue();
});

it('shows the new secret with a ready-to-paste .env line', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)
        ->test('profile::tokens')
        ->set('name', 'MacBook')
        ->call('create');

    $component->assertSee('Token “MacBook” created')
        ->assertSee('FLEXIWIND_TOKEN=');

    $component->call('dismissSecret')->assertSet('justCreated', null)->assertDontSee('created</p>', false);
});

it('refuses a token name made of markup', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('profile::tokens')
        ->set('name', '<script>alert(1)</script>')
        ->call('create')
        ->assertHasErrors(['name' => 'regex']);

    expect($user->apiTokens()->count())->toBe(0);
});

it('throttles token creation', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test('profile::tokens');

    foreach (range(1, 10) as $i) {
        $component->set('name', "token {$i}")->call('create');
    }

    $component->set('name', 'one more')->call('create')
        ->assertSet('error', fn (?string $e) => str_contains((string) $e, 'Too many'));

    expect($user->apiTokens()->count())->toBe(10);
});

it('caps the number of active tokens', function (): void {
    $user = User::factory()->create();

    foreach (range(1, 20) as $i) {
        ApiToken::issue($user, "token {$i}");
    }

    Livewire::actingAs($user)
        ->test('profile::tokens')
        ->set('name', 'one too many')
        ->call('create')
        ->assertSet('justCreated', null)
        ->assertSet('error', fn (?string $e) => $e !== null);

    expect($user->apiTokens()->count())->toBe(20);
});

it('sends a signed-out visitor away from the account pages', function (string $path): void {
    $this->get($path)->assertRedirect(route('login'));
})->with(['/account', '/account/tokens', '/account/subscription', '/account/profile']);

it('renders every account page for a signed-in visitor', function (string $path): void {
    $this->actingAs(User::factory()->create())->get($path)->assertOk();
})->with(['/account', '/account/tokens', '/account/subscription', '/account/profile']);

it('renders every account page for a team owner', function (string $path): void {
    $owner = User::factory()->create();
    app(Checkout::class)->markPaid(
        app(Checkout::class)->start($owner, Plan::find('team-lifetime')),
        'sim_test',
    );

    $this->actingAs($owner->fresh())->get($path)->assertOk();
})->with(['/account', '/account/tokens', '/account/subscription', '/account/profile', '/checkout/solo-annual']);
