{{--
    Cadre de l'espace compte : bandeau d'identité, menu latéral, titre de
    page. Le slot `actions` se place à droite du titre.
--}}
@props(['title' => '', 'description' => ''])

@php
    $user = auth()->user();
    $subscription = $user->activeSubscription();
    $role = match (true) {
        $subscription === null => null,
        $subscription->seats <= 1 => null,
        $subscription->isOwnedBy($user) => 'Owner',
        default => 'Member',
    };

    $links = [
        ['route' => 'account', 'label' => 'Overview', 'icon' => 'ph--squares-four'],
        ['route' => 'account.subscription', 'label' => 'Subscription', 'icon' => 'ph--cube'],
        ['route' => 'account.tokens', 'label' => 'CLI tokens', 'icon' => 'ph--key'],
        ['route' => 'account.profile', 'label' => 'Profile', 'icon' => 'ph--user'],
    ];
@endphp

<main class="flex-1">
    <x-site.section grid class="overflow-hidden">
        <x-site.container class="flex flex-col gap-5 py-8 sm:py-14 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                <span class="relative shrink-0">
                    <x-account.avatar :initials="$user->initials()" class="size-14 text-xl sm:size-16 sm:text-[22px]" />
                    @if ($subscription)
                        <span class="absolute -right-0.5 -bottom-0.5 flex size-5.5 items-center justify-center rounded-full bg-background text-primary">
                            <span aria-hidden="true" class="iconify ph--crown-fill text-[13px]"></span>
                        </span>
                    @endif
                </span>
                <div class="min-w-0">
                    <p class="font-display truncate text-2xl/tight font-semibold tracking-[-0.03em] text-title-foreground sm:text-[28px]/8">
                        {{ $user->name }}
                    </p>
                    <p class="mt-1.5 flex flex-wrap items-center gap-x-2.5 gap-y-1.5 text-sm text-muted-foreground">
                        <span class="truncate">{{ $user->email }}</span>
                        <span aria-hidden="true" class="size-0.75 rounded-full bg-border"></span>
                        @if ($subscription)
                            <x-account.pill tone="primary" icon="ph--crown-fill">
                                {{ $subscription->planName() }}@if ($role) · {{ $role }}@endif
                            </x-account.pill>
                        @else
                            <x-account.pill>Free plan</x-account.pill>
                        @endif
                    </p>
                </div>
            </div>
            <p class="hidden h-8.5 shrink-0 items-center rounded-[9px] bg-code px-3 font-mono text-[12.5px] whitespace-nowrap text-code-foreground md:flex"><span class="text-code-muted">$&nbsp;</span>php artisan flexi:add&nbsp;<span class="text-indigo-300">@fx/</span>login01</p>
        </x-site.container>
    </x-site.section>

    <x-site.container class="pt-8 pb-12 lg:pt-9 lg:pb-16">
        <div class="grid grid-cols-[minmax(0,1fr)] gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-8">
            <aside class="flex min-w-0 flex-col gap-4 lg:sticky lg:top-24 lg:self-start">
                <nav aria-label="Account" class="rounded-2xl border border-border bg-background p-2 shadow-xs">
                    <ul class="flex gap-0.5 overflow-x-auto [scrollbar-width:none] lg:flex-col lg:overflow-visible">
                        @foreach ($links as $link)
                            @php $isCurrent = request()->routeIs($link['route']); @endphp
                            <li class="shrink-0">
                                <a href="{{ route($link['route']) }}" wire:navigate
                                    @if ($isCurrent) aria-current="page" @endif
                                    @class([
                                        'flex h-9.5 items-center gap-2.5 rounded-[10px] px-3 text-sm whitespace-nowrap transition-colors',
                                        'bg-subtle font-medium text-title-foreground' => $isCurrent,
                                        'text-foreground hover:bg-surface hover:text-title-foreground' => ! $isCurrent,
                                    ])>
                                    <span aria-hidden="true" @class([
                                        'iconify text-base',
                                        $link['icon'],
                                        'text-primary' => $isCurrent,
                                        'text-muted-foreground' => ! $isCurrent,
                                    ])></span>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="hidden flex-col gap-0.5 rounded-2xl border border-border bg-background p-2 shadow-xs lg:flex">
                    <a href="{{ route('documentation') }}" wire:navigate
                        class="flex h-9.5 items-center gap-2.5 rounded-[10px] px-3 text-sm text-foreground transition-colors hover:bg-surface hover:text-title-foreground">
                        <span aria-hidden="true" class="iconify ph--arrow-up-right text-base text-muted-foreground"></span>
                        Documentation
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex h-9.5 w-full cursor-pointer items-center gap-2.5 rounded-[10px] px-3 text-sm text-foreground transition-colors hover:bg-surface hover:text-title-foreground">
                            <span aria-hidden="true" class="iconify ph--sign-out text-base text-muted-foreground"></span>
                            Sign out
                        </button>
                    </form>
                </div>
            </aside>

            <div class="min-w-0">
                @if ($title)
                    <header class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h1 class="font-display text-2xl/7.5 font-semibold tracking-[-0.025em] text-title-foreground">{{ $title }}</h1>
                            @if ($description)
                                <p class="mt-1 text-[14.5px] text-muted-foreground">{{ $description }}</p>
                            @endif
                        </div>
                        @isset($actions)
                            <div class="shrink-0">{{ $actions }}</div>
                        @endisset
                    </header>
                @endif

                @session('status.sent')
                    <x-account.notice tone="success" class="mb-4">{{ $value }}</x-account.notice>
                @endsession
                @session('status.error')
                    <x-account.notice tone="danger" class="mb-4">{{ $value }}</x-account.notice>
                @endsession

                {{ $slot }}
            </div>
        </div>
    </x-site.container>
</main>
