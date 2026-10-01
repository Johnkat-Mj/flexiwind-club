<?php

use App\Auth\MagicLink;
use App\Models\LoginLink;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function (): void {
    Mail::fake();
    RateLimiter::clear('magic-link:ip:127.0.0.1');
});

it('signs in through the emailed link and creates the account', function (): void {
    $magicLink = app(MagicLink::class);

    $link = LoginLink::issue('ada@example.com', '127.0.0.1');
    $url = $magicLink->url($link);

    $this->get($url)->assertRedirect(route('account'));

    $this->assertAuthenticated();
    expect(User::where('email', 'ada@example.com')->exists())->toBeTrue();
    expect($link->fresh()->consumed_at)->not->toBeNull();
});

it('refuses a link that was already used', function (): void {
    $magicLink = app(MagicLink::class);
    $link = LoginLink::issue('ada@example.com', '127.0.0.1');
    $url = $magicLink->url($link);

    $this->get($url);
    auth()->logout();

    $this->get($url)->assertRedirect(route('login'));
    $this->assertGuest();
});

it('refuses a URL whose token was tampered with', function (): void {
    $link = LoginLink::issue('ada@example.com', '127.0.0.1');
    $url = app(MagicLink::class)->url($link);

    // Toucher au secret casse d'abord la signature : la requête n'atteint
    // même pas la base.
    $this->get(str_replace($link->plainToken, str_repeat('a', 64), $url))
        ->assertForbidden();

    $this->assertGuest();
});

it('refuses a correctly signed URL carrying the wrong token', function (): void {
    $link = LoginLink::issue('ada@example.com', '127.0.0.1');

    // Deuxième barrière, testée sans la signature : le secret est comparé au
    // hash stocké.
    $user = app(MagicLink::class)->consume($link->id, str_repeat('a', 64), request());

    expect($user)->toBeNull();
    expect($link->fresh()->consumed_at)->toBeNull();
});

it('invalidates every other pending link of the same address', function (): void {
    $first = LoginLink::issue('ada@example.com', '127.0.0.1');
    $second = LoginLink::issue('ada@example.com', '127.0.0.1');

    $this->get(app(MagicLink::class)->url($second));

    expect($first->fresh()->consumed_at)->not->toBeNull();
});

it('answers the same whether the address is registered or not', function (): void {
    User::create(['name' => 'Ada', 'email' => 'known@example.com']);

    $known = Livewire::test('app-auth::login')->set('email', 'known@example.com')->call('send');
    $unknown = Livewire::test('app-auth::login')->set('email', 'stranger@example.com')->call('send');

    expect($known->get('sent'))->toBe($unknown->get('sent'))->toBeTrue();
    expect($known->get('error'))->toBe($unknown->get('error'))->toBeNull();
});

it('throttles repeated requests for the same address', function (): void {
    foreach (range(1, 3) as $i) {
        Livewire::test('app-auth::login')->set('email', 'ada@example.com')->call('send')->assertSet('sent', true);
    }

    Livewire::test('app-auth::login')
        ->set('email', 'ada@example.com')
        ->call('send')
        ->assertSet('sent', false)
        ->assertSet('error', fn (?string $e) => $e !== null);

    expect(LoginLink::count())->toBe(3);
});

it('rejects a submission that fills the honeypot', function (): void {
    Livewire::test('app-auth::login')
        ->set('email', 'bot@example.com')
        ->set('website', 'http://spam.test')
        ->call('send')
        ->assertHasErrors('website');

    expect(LoginLink::count())->toBe(0);
});
