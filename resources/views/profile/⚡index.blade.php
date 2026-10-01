<?php

use App\Support\BlockCatalog;
use Livewire\Component;

new class extends Component
{
    public function with(): array
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription();
        $isTeam = ($subscription?->seats ?? 1) > 1;

        return [
            'user' => $user,
            'subscription' => $subscription,
            'isTeam' => $isTeam,
            'isOwner' => $subscription?->isOwnedBy($user) ?? false,
            'seatsUsed' => $subscription?->seatsUsed() ?? 0,
            'activeTokens' => $user->apiTokens()->active()->count(),
            'lastUsedAt' => $user->apiTokens()->active()->max('last_used_at'),
            'members' => $isTeam ? $subscription->members()->orderByPivot('joined_at')->limit(5)->get() : collect(),
            'proBlocks' => BlockCatalog::totals()['pro'],
            'registryUrl' => url('/api/v1/pro').'/{name}',
        ];
    }
};
?>

@php
    $yaml = "registries:\n  '@fx':\n    url: {$registryUrl}\n    headers:\n      Authorization: 'Bearer \${FLEXIWIND_TOKEN}'";
@endphp

<x-account.shell title="Overview" :description="'Welcome back, ' . \Illuminate\Support\Str::before($user->name, ' ') . '. Everything your account unlocks, at a glance.'">
    <div class="grid gap-4 sm:grid-cols-3">
        <x-account.stat label="Plan" icon="ph--crown"
            :value="$subscription?->planName() ?? 'Free'"
            :hint="match (true) {
                $subscription === null => 'Pro components and blocks are locked.',
                $subscription->isLifetime() => 'Lifetime access — nothing to renew.',
                default => 'Renews ' . $subscription->ends_at->isoFormat('LL') . '.',
            }" />

        <x-account.stat label="Seats" icon="ph--users-three"
            :value="$isTeam ? $seatsUsed . ' of ' . $subscription->seats : ($subscription ? 'Just you' : '—')"
            :hint="match (true) {
                $isTeam && $seatsUsed < $subscription->seats => ($subscription->seats - $seatsUsed) . ' seats free for teammates.',
                $isTeam => 'Every seat is taken.',
                $subscription !== null => 'A personal license.',
                default => 'No subscription yet.',
            }">
            @if ($isTeam)
                <x-account.seat-meter :used="$seatsUsed" :members="$members->count()" :seats="$subscription->seats" />
            @endif
        </x-account.stat>

        <x-account.stat label="CLI tokens" icon="ph--key" :value="$activeTokens . ' active'"
            :hint="$lastUsedAt ? 'Last used ' . \Illuminate\Support\Carbon::parse($lastUsedAt)->diffForHumans() . '.' : 'Not used yet.'" />
    </div>

    <div class="mt-4 grid items-start gap-4 lg:grid-cols-[minmax(0,1.35fr)_minmax(0,1fr)]">
        <x-account.panel title="Set up the CLI" description="Three steps, then every Pro block is one command away." padding="px-5 pb-2.5 pt-1 sm:px-6">
            <x-slot:actions>
                <x-ui.button href="{{ route('account.tokens') }}" wire:navigate variant="outline" intent="gray" size="sm" class="gap-1.5 font-medium text-[13px]">
                    <span aria-hidden="true" class="iconify ph--key"></span>
                    Generate a token
                </x-ui.button>
            </x-slot:actions>

            <ol>
                <x-account.step :n="1" title="Add your token" text="Generate one in CLI tokens, then put it in the project's .env.">
                    <x-account.code-line copy="FLEXIWIND_TOKEN=" class="mt-2">FLEXIWIND_TOKEN=<span class="text-code-muted">fx_…</span></x-account.code-line>
                </x-account.step>
                <x-account.step :n="2" title="Declare the Pro registry" text="In flexiwind.yaml, next to the registries already there.">
                    <x-account.code-line :copy="$yaml" class="mt-2 items-start py-2.5" />
                </x-account.step>
                <x-account.step :n="3" title="Pull a Pro block" text="Its dependencies come with it.">
                    <x-account.code-line copy="php artisan flexi:add @fx/login01" class="mt-2">php artisan flexi:add <span class="text-indigo-300">@fx/</span>login01</x-account.code-line>
                </x-account.step>
            </ol>
        </x-account.panel>

        <div class="flex flex-col gap-4">
            <x-account.panel :title="$subscription ? 'Unlocked with Pro' : 'Unlock with Pro'" padding="px-5 pb-2 pt-1 sm:px-5.5">
                @foreach ([
                    ['Pro blocks', $proBlocks . ' blocks', route('blocks.list')],
                    ['Pro components', 'Select, charts…', route('components')],
                    ['Source of every Pro example', 'Docs', route('documentation')],
                    ['The @fx/ registry', 'CLI', route('account.tokens')],
                ] as [$label, $meta, $href])
                    <a href="{{ $href }}" wire:navigate
                        class="group flex h-11 items-center justify-between gap-3 border-t border-border/60 text-sm text-title-foreground first:border-t-0">
                        <span class="flex items-center gap-2.5">
                            <span aria-hidden="true" @class([
                                'iconify text-base',
                                'ph--check-circle-fill text-emerald-600 dark:text-emerald-400' => $subscription,
                                'ph--lock-simple text-muted-foreground' => ! $subscription,
                            ])></span>
                            {{ $label }}
                        </span>
                        <span class="flex items-center gap-1 text-[13px] text-muted-foreground group-hover:text-foreground">
                            {{ $meta }}
                            <span aria-hidden="true" class="iconify ph--caret-right text-xs"></span>
                        </span>
                    </a>
                @endforeach
                @unless ($subscription)
                    <x-ui.button href="{{ route('pricing') }}" wire:navigate variant="solid" intent="primary" size="sm" class="my-3 w-full justify-center font-medium text-[13px]">
                        See the plans
                    </x-ui.button>
                @endunless
            </x-account.panel>

            @if ($isTeam)
                <x-account.panel title="Your team" padding="px-5 pb-2 pt-1 sm:px-5.5">
                    <x-slot:actions>
                        <x-ui.button href="{{ route('account.subscription') }}" wire:navigate variant="ghost" intent="gray" size="sm" class="-mt-1 -mr-2 font-medium text-[13px]">
                            {{ $isOwner ? 'Manage' : 'View' }}
                        </x-ui.button>
                    </x-slot:actions>
                    @foreach ($members as $member)
                        <div class="flex h-11 items-center gap-2.5 border-t border-border/60 first:border-t-0">
                            <x-account.avatar :initials="$member->initials()" class="size-7 text-[11px]" />
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[13.5px] font-medium text-title-foreground">{{ $member->name }}</p>
                                <p class="truncate text-xs text-muted-foreground">{{ $member->is($user) ? 'you' : $member->email }}</p>
                            </div>
                            <x-account.pill :tone="$member->id === $subscription->owner_id ? 'dark' : 'gray'">
                                {{ $member->id === $subscription->owner_id ? 'Owner' : 'Member' }}
                            </x-account.pill>
                        </div>
                    @endforeach
                </x-account.panel>
            @endif
        </div>
    </div>
</x-account.shell>
