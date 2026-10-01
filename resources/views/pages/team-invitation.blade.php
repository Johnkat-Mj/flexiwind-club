{{--
    Ce qu'on voit en suivant le lien d'invitation. Rien n'est accepté tant
    que la personne n'a pas cliqué : le bouton poste vers la même URL signée.
--}}
<x-layouts::site>
    <main class="relative flex flex-1 items-start justify-center overflow-hidden border-b border-border px-4 pt-16 pb-24 sm:pt-20">
        <div aria-hidden="true" class="bg-grid pointer-events-none absolute inset-y-0 left-1/2 w-full max-w-300 -translate-x-1/2"></div>

        <div class="relative flex w-full max-w-90 flex-col gap-4 rounded-[20px] border border-border bg-background px-6 pt-8 pb-7 shadow-[0_1px_2px_rgba(9,9,11,.04),0_30px_60px_-36px_rgba(9,9,11,.35)] sm:px-7.5">
            <span class="flex items-center">
                <x-account.avatar :initials="$inviter->initials()" class="size-11 text-[15px] ring-3 ring-background" />
                <span class="-ml-2.5 flex size-11 items-center justify-center rounded-full border-[1.5px] border-dashed border-border bg-background text-muted-foreground">
                    <span aria-hidden="true" class="iconify ph--user-plus text-lg"></span>
                </span>
            </span>

            <div>
                <h1 class="font-display text-[22px] font-semibold tracking-[-0.02em] text-title-foreground">
                    Join {{ \Illuminate\Support\Str::before($inviter->name, ' ') }}'s team
                </h1>
                <p class="mt-1.5 text-sm/[21px] text-muted-foreground">
                    {{ $inviter->name }} invited <span class="font-medium text-title-foreground">{{ $invitation->email }}</span>
                    to a seat on {{ $planName }}. You get every Pro component and your own CLI tokens.
                </p>
            </div>

            <ul class="flex flex-col gap-2">
                @foreach (['All Pro components and blocks', 'Your own sign-in and tokens', 'Nothing to pay'] as $perk)
                    <li class="flex items-center gap-2 text-[13.5px] text-foreground">
                        <span aria-hidden="true" class="iconify ph--check text-sm text-emerald-600 dark:text-emerald-400"></span>
                        {{ $perk }}
                    </li>
                @endforeach
            </ul>

            @if ($user && ! $matchesInvitedAddress)
                <x-account.notice tone="danger">
                    You are signed in as {{ $user->email }}. Sign out, then open this link again and sign in with {{ $invitation->email }}.
                </x-account.notice>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-ui.button type="submit" variant="outline" intent="gray" class="w-full justify-center font-medium">Sign out</x-ui.button>
                </form>
            @else
                <form method="POST" action="{{ request()->fullUrl() }}">
                    @csrf
                    <x-ui.button type="submit" variant="solid" intent="primary" class="h-10.5 w-full justify-center font-medium">
                        {{ $user ? 'Accept invitation' : 'Accept and sign in' }}
                    </x-ui.button>
                </form>
            @endif

            <p class="text-[12.5px] text-muted-foreground">
                Expires {{ $invitation->expires_at->diffForHumans() }}. Not you? Just ignore it.
            </p>
        </div>
    </main>
</x-layouts::site>
