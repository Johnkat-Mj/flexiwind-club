<?php

use App\Auth\MagicLink;
use App\Auth\MagicLinkStatus;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('required|string|email:rfc|max:254')]
    public string $email = '';

    /** Champ leurre : un humain ne le voit pas, un bot le remplit. */
    #[Validate('prohibited')]
    public string $website = '';

    public bool $sent = false;

    public ?string $error = null;

    public function mount(): void
    {
        // Arrivée depuis une invitation : l'adresse invitée est pré-remplie.
        $this->email = (string) session('login.email', '');
    }

    public function send(MagicLink $magicLink): void
    {
        $this->validate();

        $status = $magicLink->request($this->email, request());

        if ($status === MagicLinkStatus::Throttled) {
            $this->error = 'Too many links requested for now. Wait a few minutes and try again.';

            return;
        }

        // Même écran que l'adresse soit inscrite ou non : la page ne révèle
        // jamais qui a un compte.
        $this->error = null;
        $this->sent = true;
    }

    public function reset_form(): void
    {
        $this->sent = false;
        $this->error = null;
    }
};
?>

<main class="relative flex flex-1 items-start justify-center overflow-hidden border-b border-border px-4 pt-16 pb-24 sm:pt-20">
    <div aria-hidden="true" class="bg-grid pointer-events-none absolute inset-y-0 left-1/2 w-full max-w-300 -translate-x-1/2"></div>

    <div class="relative flex w-full max-w-90 flex-col gap-4 rounded-[20px] border border-border bg-background px-6 pt-8 pb-7 shadow-[0_1px_2px_rgba(9,9,11,.04),0_30px_60px_-36px_rgba(9,9,11,.35)] sm:px-7.5">
        @if ($sent)
            <span class="flex size-12 items-center justify-center rounded-full bg-emerald-600/13 text-emerald-700 dark:text-emerald-400">
                <span aria-hidden="true" class="iconify ph--paper-plane-tilt text-[22px]"></span>
            </span>
            <div>
                <h1 class="font-display text-[22px] font-semibold tracking-[-0.02em] text-title-foreground">Check your inbox</h1>
                <p class="mt-1.5 text-sm/[21px] text-muted-foreground">
                    If <span class="font-medium text-title-foreground">{{ $email }}</span> can receive mail, a sign-in
                    link is on its way. It works once and expires in 15 minutes.
                </p>
            </div>
            <div class="rounded-xl border border-border bg-surface px-3.5 py-3">
                <p class="text-[12.5px] font-medium text-title-foreground">Nothing yet?</p>
                <p class="mt-1 text-[12.5px]/4.5 text-muted-foreground">Look in spam or promotions. You can ask for a new link in a minute.</p>
            </div>
            <x-ui.button wire:click="reset_form" variant="outline" intent="gray" class="w-full justify-center gap-1.5 font-medium">
                <span aria-hidden="true" class="iconify ph--arrow-counter-clockwise"></span>
                Use another address
            </x-ui.button>
        @else
            <span class="flex size-11 items-center justify-center rounded-xl border border-border bg-background shadow-[0_6px_16px_-10px_rgba(9,9,11,.3)] [&_svg]:size-5.5">
                <x-atoms.logo />
            </span>
            <div>
                <h1 class="font-display text-[22px] font-semibold tracking-[-0.02em] text-title-foreground">Sign in to Flexiwind</h1>
                <p class="mt-1.5 text-sm/[21px] text-muted-foreground">
                    No password. Enter your email and we send you a link — it creates your account if you don't have one.
                </p>
            </div>

            @if ($error)
                <x-account.notice tone="danger">{{ $error }}</x-account.notice>
            @endif
            @session('status.error')
                <x-account.notice tone="danger">{{ $value }}</x-account.notice>
            @endsession
            @session('status.info')
                <x-account.notice>{{ $value }}</x-account.notice>
            @endsession

            <form wire:submit="send" class="flex flex-col gap-4">
                <x-account.field id="email" label="Email address" icon="ph--envelope-simple" wire:model="email" type="email"
                    name="email" autocomplete="email" required placeholder="you@company.com" :error="$errors->first('email') ?: null" />

                {{-- Leurre : hors flux, invisible, jamais annoncé aux lecteurs d'écran. --}}
                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input wire:model="website" type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <x-ui.button type="submit" variant="solid" intent="primary" class="h-10.5 w-full justify-center gap-1.5 font-medium"
                    wire:loading.attr="disabled" wire:target="send">
                    <span aria-hidden="true" class="iconify ph--paper-plane-tilt"></span>
                    <span wire:loading.remove wire:target="send">Send me a link</span>
                    <span wire:loading wire:target="send">Sending…</span>
                </x-ui.button>
            </form>

            <p class="flex items-center gap-2 text-[12.5px] text-muted-foreground">
                <span aria-hidden="true" class="iconify ph--shield-check shrink-0 text-[15px] text-emerald-600 dark:text-emerald-400"></span>
                The link works once and expires in 15 minutes.
            </p>
        @endif
    </div>
</main>
