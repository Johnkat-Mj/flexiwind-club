<?php

use App\Billing\Plan;
use App\Billing\Team;
use App\Models\Subscription;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('required|string|email:rfc|max:254')]
    public string $inviteEmail = '';

    public ?string $error = null;

    public ?string $notice = null;

    /**
     * Membre dont le retrait attend confirmation. Modifiable depuis le
     * navigateur comme toute propriété publique : ce n'est qu'un affichage,
     * removeMember() revérifie tout côté serveur.
     */
    public ?int $confirmingRemoval = null;

    public function invite(Team $team): void
    {
        $this->validate();

        $subscription = $this->ownedTeam();

        if ($subscription === null) {
            $this->error = 'You do not own a team subscription.';

            return;
        }

        try {
            $team->invite($subscription, auth()->user(), $this->inviteEmail);
        } catch (\RuntimeException $e) {
            $this->error = $e->getMessage();
            $this->notice = null;

            return;
        }

        $this->error = null;
        $this->notice = "Invitation sent to {$this->inviteEmail}. The link is valid for 7 days.";
        $this->inviteEmail = '';
    }

    public function revokeInvitation(int $invitationId): void
    {
        // Portée par la relation : une invitation d'un autre abonnement est
        // simplement introuvable.
        $invitation = $this->ownedTeam()?->pendingInvitations()->whereKey($invitationId)->first();

        if ($invitation === null) {
            return;
        }

        $invitation->revoke();
        $this->error = null;
        $this->notice = "Invitation to {$invitation->email} revoked.";
    }

    public function askRemoval(int $userId): void
    {
        $subscription = $this->ownedTeam();

        $this->confirmingRemoval = $subscription !== null
            && $userId !== $subscription->owner_id
            && $subscription->members()->whereKey($userId)->exists()
                ? $userId
                : null;
    }

    public function cancelRemoval(): void
    {
        $this->confirmingRemoval = null;
    }

    public function removeMember(Team $team): void
    {
        $userId = $this->confirmingRemoval;
        $this->confirmingRemoval = null;
        $subscription = $this->ownedTeam();

        if ($subscription === null || $userId === null) {
            return;
        }

        try {
            $team->removeMember($subscription, auth()->user(), $userId);
        } catch (\RuntimeException $e) {
            $this->error = $e->getMessage();

            return;
        }

        $this->error = null;
        $this->notice = 'Seat freed. Their tokens were revoked.';
    }

    private function ownedTeam(): ?Subscription
    {
        return auth()->user()->ownedTeamSubscription();
    }

    public function with(): array
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription();
        $isTeam = ($subscription?->seats ?? 1) > 1;
        $isOwner = $subscription?->isOwnedBy($user) ?? false;

        $members = $isTeam
            ? $subscription->members()
                ->withCount(['apiTokens as active_tokens_count' => fn ($query) => $query->whereNull('revoked_at')])
                ->orderByPivot('joined_at')
                ->get()
            : collect();

        return [
            'user' => $user,
            'subscription' => $subscription,
            'plan' => $subscription?->plan(),
            'isOwner' => $isOwner,
            'isTeam' => $isTeam,
            'members' => $members,
            'pending' => $isTeam ? $subscription->pendingInvitations()->oldest()->get() : collect(),
            'paid' => $subscription ? Plan::money($subscription->amount_cents, $subscription->currency) : null,
            'joinedAt' => $subscription ? $members->firstWhere('id', $user->id)?->pivot?->joined_at : null,
            'plans' => $subscription ? [] : Plan::all(),
            'removing' => $this->confirmingRemoval ? $members->firstWhere('id', $this->confirmingRemoval) : null,
        ];
    }
};
?>

<x-account.shell title="Subscription" description="Your plan, and who it covers.">
    @if ($error)
        <x-account.notice tone="danger" class="mb-4">{{ $error }}</x-account.notice>
    @endif
    @if ($notice)
        <x-account.notice tone="success" class="mb-4">{{ $notice }}</x-account.notice>
    @endif

    @if (! $subscription)
        <x-account.panel padding="p-0">
            <div class="flex flex-col items-center gap-2.5 px-6 pt-9 pb-7 text-center">
                <span class="flex size-13 items-center justify-center rounded-[14px] bg-subtle text-title-foreground">
                    <span aria-hidden="true" class="iconify ph--cube text-2xl"></span>
                </span>
                <h2 class="font-display mt-1 text-xl font-semibold tracking-[-0.02em] text-title-foreground">You're on the free plan</h2>
                <p class="max-w-115 text-[14.5px]/5.5 text-muted-foreground">
                    Free components stay free. Pro unlocks the Pro components and blocks, and the source behind every locked example.
                </p>
            </div>
            <div class="grid gap-3 px-5 pb-6 sm:grid-cols-3 sm:px-6">
                @foreach ($plans as $option)
                    <div @class([
                        'flex flex-col gap-2.5 rounded-[14px] border bg-background p-4.5',
                        'border-primary ring-3 ring-primary/12' => $option->featured,
                        'border-border' => ! $option->featured,
                    ])>
                        <p class="flex items-center justify-between gap-2 text-[14.5px] font-semibold text-title-foreground">
                            {{ $option->name }}
                            @if ($option->featured)
                                <x-account.pill tone="primary">Most popular</x-account.pill>
                            @endif
                        </p>
                        <p class="flex items-baseline gap-1.5">
                            <span class="font-display text-[26px] font-semibold tracking-[-0.03em] text-title-foreground">{{ $option->formattedPrice() }}</span>
                            <span class="text-[13px] text-muted-foreground">{{ $option->billingLabel }}</span>
                        </p>
                        <x-ui.button href="{{ route('checkout.show', ['plan' => $option->key]) }}" wire:navigate
                            :variant="$option->featured ? 'solid' : 'outline'" :intent="$option->featured ? 'primary' : 'gray'"
                            class="mt-auto w-full justify-center font-medium">
                            Get {{ $option->name }}
                        </x-ui.button>
                    </div>
                @endforeach
            </div>
        </x-account.panel>
    @else
        <x-account.panel padding="p-0">
            <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-start sm:justify-between sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-[13px] bg-primary text-white shadow-lg shadow-primary/30">
                        <span aria-hidden="true" class="iconify ph--crown-fill text-[22px]"></span>
                    </span>
                    <div>
                        <p class="flex flex-wrap items-center gap-2.5">
                            <span class="font-display text-[22px] font-semibold tracking-[-0.02em] text-title-foreground">{{ $subscription->planName() }}</span>
                            <x-account.pill tone="success">Active</x-account.pill>
                        </p>
                        <p class="mt-1 text-sm text-muted-foreground">
                            @if (! $isOwner)
                                Your seat on {{ $subscription->owner->name }}'s subscription.
                            @elseif ($subscription->isLifetime())
                                Lifetime access{{ $isTeam ? ' for ' . $subscription->seats . ' people' : '' }} — nothing to renew.
                            @else
                                Renews on {{ $subscription->ends_at->isoFormat('LL') }}.
                            @endif
                        </p>
                    </div>
                </div>
                <x-ui.button href="{{ route('pricing') }}" wire:navigate variant="outline" intent="gray" class="shrink-0 font-medium">Compare plans</x-ui.button>
            </div>

            <dl class="grid gap-4 border-t border-border bg-surface px-5 py-4 sm:grid-cols-3 sm:gap-6 sm:px-6">
                <div>
                    <dt class="text-[12.5px] text-muted-foreground">Paid</dt>
                    <dd class="mt-1 text-[15px] font-semibold text-title-foreground">
                        {{ $isOwner ? $paid . ' ' . ($subscription->isLifetime() ? 'one time' : 'per year') : 'Paid by ' . \Illuminate\Support\Str::before($subscription->owner->name, ' ') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-[12.5px] text-muted-foreground">
                        {{ ! $isOwner ? 'Joined' : ($subscription->isLifetime() ? 'Since' : 'Next renewal') }}
                    </dt>
                    <dd class="mt-1 text-[15px] font-semibold text-title-foreground">
                        @if (! $isOwner)
                            {{ $joinedAt?->isoFormat('ll') ?? '—' }}
                        @elseif ($subscription->isLifetime())
                            {{ $subscription->starts_at?->isoFormat('ll') }}
                        @else
                            {{ $subscription->ends_at->isoFormat('ll') }}
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-[12.5px] text-muted-foreground">
                        Seats{{ $isTeam ? ' · ' . $subscription->seatsUsed() . ' of ' . $subscription->seats : '' }}
                    </dt>
                    <dd class="mt-1">
                        @if ($isTeam)
                            <x-account.seat-meter :used="$subscription->seatsUsed()" :members="$members->count()" :seats="$subscription->seats" class="pt-1.5" />
                        @else
                            <span class="text-[15px] font-semibold text-title-foreground">Just you</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </x-account.panel>

        @if ($isTeam)
            <x-account.panel padding="p-0" class="mt-4">
                <div class="flex items-start justify-between gap-4 px-5 pt-5 pb-4 sm:px-6">
                    <div>
                        <h2 class="font-display text-[17px] font-semibold text-title-foreground">Team</h2>
                        <p class="mt-0.5 text-[13.5px] text-muted-foreground">
                            {{ $isOwner ? 'Everyone here can pull Pro components with their own tokens.' : 'The people who share this subscription.' }}
                        </p>
                    </div>
                    <p class="shrink-0 text-[13.5px] font-medium text-title-foreground">{{ $subscription->seatsUsed() }} of {{ $subscription->seats }} seats</p>
                </div>

                <ul>
                    @foreach ($members as $member)
                        <li wire:key="member-{{ $member->id }}" class="flex min-h-16 items-center gap-3 border-t border-border/60 px-5 py-3 sm:px-6">
                            <x-account.avatar :initials="$member->initials()" class="size-8.5 text-xs" />
                            <div class="min-w-0 flex-1">
                                <p class="flex flex-wrap items-center gap-2 text-[14.5px] font-medium text-title-foreground">
                                    <span class="truncate">{{ $member->name }}</span>
                                    @if ($member->id === $subscription->owner_id)
                                        <x-account.pill tone="dark">Owner</x-account.pill>
                                    @endif
                                    @if ($member->is($user))
                                        <x-account.pill>You</x-account.pill>
                                    @endif
                                </p>
                                <p class="truncate text-[13px] text-muted-foreground">
                                    {{ $member->email }}
                                    @if ($isOwner)
                                        · {{ $member->active_tokens_count }} {{ \Illuminate\Support\Str::plural('token', $member->active_tokens_count) }}
                                    @endif
                                </p>
                            </div>
                            @if ($isOwner && $member->id !== $subscription->owner_id)
                                <x-ui.button type="button" wire:click="askRemoval({{ $member->id }})" variant="ghost" intent="gray" size="sm" class="font-medium text-[13px]">
                                    Remove
                                </x-ui.button>
                            @endif
                        </li>
                    @endforeach

                    @foreach ($pending as $invitation)
                        <li wire:key="invite-{{ $invitation->id }}" class="flex min-h-16 items-center gap-3 border-t border-border/60 px-5 py-3 sm:px-6">
                            <span class="flex size-8.5 shrink-0 items-center justify-center rounded-full border-[1.5px] border-dashed border-border text-muted-foreground">
                                <span aria-hidden="true" class="iconify ph--envelope-simple text-[15px]"></span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="flex flex-wrap items-center gap-2 text-[14.5px] text-title-foreground">
                                    <span class="truncate">{{ $invitation->email }}</span>
                                    <x-account.pill tone="warning">Invited</x-account.pill>
                                </p>
                                <p class="text-[13px] text-muted-foreground">
                                    Invited {{ $invitation->created_at->diffForHumans() }} · expires {{ $invitation->expires_at->diffForHumans() }}
                                </p>
                            </div>
                            @if ($isOwner)
                                <x-ui.button type="button" wire:click="revokeInvitation({{ $invitation->id }})" variant="ghost" intent="gray" size="sm" class="font-medium text-[13px]">
                                    Revoke
                                </x-ui.button>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if ($isOwner && $subscription->hasSeatAvailable())
                    <div class="border-t border-border bg-surface px-5 pt-4.5 pb-4 sm:px-6">
                        <form wire:submit="invite" class="flex flex-col gap-2.5 sm:flex-row sm:items-end">
                            <div class="flex-1">
                                <x-account.field id="inviteEmail" label="Invite a teammate" icon="ph--envelope-simple" wire:model="inviteEmail"
                                    type="email" name="inviteEmail" placeholder="teammate@company.com" autocomplete="off"
                                    :invalid="$errors->has('inviteEmail')" described-by="inviteEmail-error" />
                            </div>
                            <x-ui.button type="submit" variant="solid" intent="primary" class="h-10 gap-1.5 font-medium" wire:loading.attr="disabled" wire:target="invite">
                                <span aria-hidden="true" class="iconify ph--paper-plane-tilt"></span>
                                Send invite
                            </x-ui.button>
                        </form>
                        @error('inviteEmail')
                            <p id="inviteEmail-error" class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                        @enderror
                        <p class="mt-3 text-[12.5px] text-muted-foreground">
                            They get a signed link, valid 7 days. Each member signs in with their own email and manages their own tokens.
                        </p>
                    </div>
                @elseif ($isOwner)
                    <p class="flex items-center gap-2.5 border-t border-border bg-surface px-5 py-4 text-[13.5px] text-muted-foreground sm:px-6">
                        <span aria-hidden="true" class="iconify ph--info shrink-0 text-base"></span>
                        All {{ $subscription->seats }} seats are taken. Remove someone or revoke an invitation to free one up.
                    </p>
                @else
                    <p class="flex items-center gap-2.5 border-t border-border bg-surface px-5 py-4 text-[13.5px] text-muted-foreground sm:px-6">
                        <span aria-hidden="true" class="iconify ph--info shrink-0 text-base"></span>
                        Only {{ \Illuminate\Support\Str::before($subscription->owner->name, ' ') }} can invite or remove people. Your seat and your tokens are yours.
                    </p>
                @endif
            </x-account.panel>
        @endif
    @endif

    <x-account.confirm :show="$removing !== null" :title="'Remove ' . ($removing?->name ?? '') . '?'" icon="ph--warning"
        cancel="cancelRemoval" confirm="removeMember" confirm-label="Remove member">
        Their seat is freed and their CLI tokens are revoked right away. Any machine using them stops pulling Pro components.
    </x-account.confirm>
</x-account.shell>
