<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Models\ApiToken;
use App\Models\RegistryDownload;
use App\Models\User;

function registryToken(bool $pro = false): string
{
    $user = User::factory()->create();

    if ($pro) {
        app(Checkout::class)->markPaid(
            app(Checkout::class)->start($user, Plan::find('solo-lifetime')),
            'sim_registry',
        );
    }

    return ApiToken::issue($user->fresh(), 'cli')->plainText;
}

it('serves a pro block under the name the CLI sends, without the @fx prefix', function (): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/pro/login01')
        ->assertOk()
        ->assertJsonPath('name', 'login01')
        ->assertJsonStructure(['files' => [['target', 'content']]])
        ->assertHeader('Cache-Control', 'max-age=0, no-store, private');
});

it('accepts a trailing .json in the configured URL', function (): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/pro/login01.json')
        ->assertOk()
        ->assertJsonPath('name', 'login01');
});

it('serves pro components as well as blocks', function (): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/pro/select-pro')
        ->assertOk();
});

it('refuses a pro source without a token', function (): void {
    $this->getJson('/api/v1/pro/login01')
        ->assertUnauthorized()
        ->assertHeader('WWW-Authenticate', 'Bearer');
});

it('refuses a pro source to an account with no active subscription', function (): void {
    $this->withToken(registryToken())
        ->getJson('/api/v1/pro/login01')
        ->assertForbidden()
        ->assertJsonPath('upgrade_url', route('pricing'))
        ->assertJsonMissingPath('files');
});

it('answers the same for an unknown name when there is no subscription', function (): void {
    $this->withToken(registryToken())
        ->getJson('/api/v1/pro/does-not-exist')
        ->assertForbidden();
});

it('cuts access as soon as the token is revoked', function (): void {
    $secret = registryToken(pro: true);
    ApiToken::findActive($secret)->revoke();

    $this->withToken($secret)->getJson('/api/v1/pro/login01')->assertUnauthorized();
});

it('stops serving once the subscription expires', function (): void {
    $secret = registryToken(pro: true);
    ApiToken::findActive($secret)->user->activeSubscription()
        ->forceFill(['ends_at' => now()->subDay()])->save();

    $this->withToken($secret)->getJson('/api/v1/pro/login01')->assertForbidden();
});

it('only serves names from the catalog', function (string $name): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/pro/'.$name)
        ->assertNotFound();
})->with([
    'unknown' => 'nope',
    'traversal' => '..%2F..%2F.env',
    'nested' => 'a/b',
    'uppercase' => 'LOGIN01',
    'env file' => '.env',
]);

it('records who pulled which pro source, from where', function (): void {
    $secret = registryToken(pro: true);

    $this->withToken($secret)->getJson('/api/v1/pro/login01')->assertOk();

    $download = RegistryDownload::sole();
    expect($download->item)->toBe('login01')
        ->and($download->api_token_id)->toBe(ApiToken::findActive($secret)->id)
        ->and($download->ip)->toBe('127.0.0.1');
});

it('lists the pro catalog without the sources', function (): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/pro')
        ->assertOk()
        ->assertJsonPath('name', '@fx')
        ->assertJsonStructure(['items' => [['name', 'type', 'title', 'description']]])
        ->assertJsonMissingPath('items.0.files');
});

it('keeps the legacy @fx/ address working', function (): void {
    $this->withToken(registryToken(pro: true))
        ->getJson('/api/v1/registry/@fx/login01')
        ->assertOk()
        ->assertJsonPath('name', 'login01');
});

it('limits each token to 60 calls a minute', function (): void {
    $secret = registryToken(pro: true);

    foreach (range(1, 60) as $i) {
        $this->withToken($secret)->getJson('/api/v1/me')->assertOk();
    }

    $this->withToken($secret)->getJson('/api/v1/me')->assertTooManyRequests();
});

it('blocks an address that keeps presenting invalid tokens', function (): void {
    foreach (range(1, 10) as $i) {
        $this->withToken('fx_'.str_repeat((string) ($i % 10), 48))->getJson('/api/v1/me')->assertUnauthorized();
    }

    $this->withToken(registryToken(pro: true))->getJson('/api/v1/me')->assertTooManyRequests();
});

it('sends security headers on every page', function (): void {
    $this->get('/')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});
