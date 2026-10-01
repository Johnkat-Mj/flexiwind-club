<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Billing\Team;
use App\Mail\TeamInvitationMail;
use App\Models\ApiToken;
use App\Models\Invitation;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function (): void {
    Mail::fake();

    $this->owner = User::factory()->create(['email' => 'owner@example.com']);
    $this->subscription = app(Checkout::class)->markPaid(
        app(Checkout::class)->start($this->owner, Plan::find('team-lifetime')),
        'sim_test',
    );
});

it('counts the owner as the first of five seats', function (): void {
    expect($this->subscription->seats)->toBe(5)
        ->and($this->subscription->seatsUsed())->toBe(1)
        ->and($this->subscription->seatsLeft())->toBe(4);
});

it('lets the owner invite someone and mails them', function (): void {
    app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');

    Mail::assertSent(TeamInvitationMail::class);
    expect($this->subscription->fresh()->seatsUsed())->toBe(2);
});

it('refuses an invitation from someone who is not the owner', function (): void {
    $member = User::factory()->create();

    expect(fn () => app(Team::class)->invite($this->subscription, $member, 'mate@example.com'))
        ->toThrow(RuntimeException::class);
});

it('stops at five seats, invitations included', function (): void {
    foreach (['a', 'b', 'c', 'd'] as $letter) {
        app(Team::class)->invite($this->subscription->fresh(), $this->owner, "{$letter}@example.com");
    }

    expect(fn () => app(Team::class)->invite($this->subscription->fresh(), $this->owner, 'fifth@example.com'))
        ->toThrow(RuntimeException::class);

    expect(Invitation::count())->toBe(4);
});

it('gives the invited account its own pro access', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $url = app(Team::class)->acceptUrl(tap($invitation, fn ($i) => $i->plainToken ??= null));

    $mate = User::factory()->create(['email' => 'mate@example.com']);

    $this->actingAs($mate)->post($url)->assertRedirect(route('account.subscription'));

    expect($mate->fresh()->hasProAccess())->toBeTrue()
        ->and($invitation->fresh()->accepted_at)->not->toBeNull();
});

it('refuses an invitation claimed from another address', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $url = app(Team::class)->acceptUrl($invitation);

    $stranger = User::factory()->create(['email' => 'stranger@example.com']);

    $this->actingAs($stranger)->post($url)->assertRedirect(route('account'));

    expect($stranger->fresh()->hasProAccess())->toBeFalse()
        ->and($invitation->fresh()->accepted_at)->toBeNull();
});

it('sends a signed-out visitor to sign in before claiming a seat', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');

    $this->post(app(Team::class)->acceptUrl($invitation))->assertRedirect(route('login'));

    expect($invitation->fresh()->accepted_at)->toBeNull();
});

it('revokes the tokens of a member removed from the team', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $mate = User::factory()->create(['email' => 'mate@example.com']);
    $this->actingAs($mate)->post(app(Team::class)->acceptUrl($invitation));

    $token = ApiToken::issue($mate, 'laptop');
    expect($mate->fresh()->hasProAccess())->toBeTrue();

    app(Team::class)->removeMember($this->subscription->fresh(), $this->owner, $mate->id);

    expect($mate->fresh()->hasProAccess())->toBeFalse()
        ->and($token->fresh()->isRevoked())->toBeTrue()
        ->and($this->subscription->fresh()->seatsLeft())->toBe(4);
});

it('will not let the owner remove their own seat', function (): void {
    expect(fn () => app(Team::class)->removeMember($this->subscription, $this->owner, $this->owner->id))
        ->toThrow(RuntimeException::class);
});

it('refuses a member removal requested by someone who is not the owner', function (): void {
    $intruder = User::factory()->create();

    expect(fn () => app(Team::class)->removeMember($this->subscription, $intruder, $this->owner->id))
        ->toThrow(RuntimeException::class);
});

it('does not let one owner revoke another team\'s invitation', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');

    $otherOwner = User::factory()->create();
    app(Checkout::class)->markPaid(
        app(Checkout::class)->start($otherOwner, Plan::find('team-lifetime')),
        'sim_other',
    );

    Livewire::actingAs($otherOwner)
        ->test('profile::subscription')
        ->call('revokeInvitation', $invitation->id);

    expect($invitation->fresh()->revoked_at)->toBeNull();
});

it('keeps a seat holder out of the owner-only controls', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $mate = User::factory()->create(['email' => 'mate@example.com']);
    $this->actingAs($mate)->post(app(Team::class)->acceptUrl($invitation));

    Livewire::actingAs($mate)
        ->test('profile::subscription')
        ->call('askRemoval', $this->owner->id)
        ->assertSet('confirmingRemoval', null)
        ->set('confirmingRemoval', $this->owner->id)
        ->call('removeMember')
        ->assertSet('error', null);

    expect(Subscription::find($this->subscription->id)->members()->count())->toBe(2);
});

it('shows the invitation without accepting it when the link is opened', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $mate = User::factory()->create(['email' => 'mate@example.com']);

    $this->actingAs($mate)->get(app(Team::class)->acceptUrl($invitation))
        ->assertOk()
        ->assertSee('Accept invitation');

    expect($invitation->fresh()->accepted_at)->toBeNull()
        ->and($mate->fresh()->hasProAccess())->toBeFalse();
});

it('refuses an accept request whose signature was tampered with', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $mate = User::factory()->create(['email' => 'mate@example.com']);

    $this->actingAs($mate)
        ->post(app(Team::class)->acceptUrl($invitation).'x')
        ->assertForbidden();

    expect($invitation->fresh()->accepted_at)->toBeNull();
});

it('keeps the invited address out of the sign-in URL', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');

    $response = $this->post(app(Team::class)->acceptUrl($invitation));

    expect($response->headers->get('Location'))->not->toContain('mate')
        ->and(session('login.email'))->toBe('mate@example.com');
});

it('asks for confirmation before removing a member, then revokes their tokens', function (): void {
    $invitation = app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com');
    $mate = User::factory()->create(['email' => 'mate@example.com']);
    $this->actingAs($mate)->post(app(Team::class)->acceptUrl($invitation));
    $token = ApiToken::issue($mate, 'laptop');

    Livewire::actingAs($this->owner)
        ->test('profile::subscription')
        ->call('askRemoval', $mate->id)
        ->assertSet('confirmingRemoval', $mate->id)
        ->assertSee('Remove member')
        ->call('removeMember')
        ->assertSet('confirmingRemoval', null);

    expect($token->fresh()->isRevoked())->toBeTrue()
        ->and($mate->fresh()->hasProAccess())->toBeFalse();
});

it('throttles invitations sent by one owner', function (): void {
    foreach (range(1, 20) as $n) {
        RateLimiter::hit('team-invites:'.$this->owner->id, 3600);
    }

    expect(fn () => app(Team::class)->invite($this->subscription, $this->owner, 'mate@example.com'))
        ->toThrow(RuntimeException::class, 'Too many invitations');
});
