<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate(['required', 'string', 'min:2', 'max:80', 'regex:/^[\pL\pM\pN][\pL\pM\pN .\'_-]*$/u'], message: [
        'regex' => 'Use letters, numbers, spaces, apostrophes and hyphens.',
    ])]
    public string $name = '';

    public bool $saved = false;

    public function mount(): void
    {
        $this->name = auth()->user()->name;
    }

    public function updatedName(): void
    {
        $this->saved = false;
    }

    public function save(): void
    {
        $this->name = trim(preg_replace('/\s+/u', ' ', $this->name));
        $this->validate();

        // L'adresse mail EST l'identité : la changer changerait de compte.
        // Elle n'est donc pas modifiable ici, et seul le nom est écrit.
        auth()->user()->forceFill(['name' => $this->name])->save();

        $this->saved = true;
    }
};
?>

<x-account.shell title="Profile" description="How you appear to the rest of your team.">
    <form wire:submit="save" class="overflow-hidden rounded-2xl border border-border bg-background shadow-xs">
        <header class="border-b border-border px-5 pt-5 pb-4 sm:px-6">
            <h2 class="font-display text-[17px] font-semibold tracking-[-0.015em] text-title-foreground">Personal details</h2>
            <p class="mt-0.5 text-[13.5px] text-muted-foreground">Your name shows on your team and in invitations you send.</p>
        </header>

        <div class="flex flex-col gap-6 p-5 sm:flex-row sm:items-start sm:gap-7 sm:px-6 sm:pt-6 sm:pb-5"
            x-data="{
                name: @js($name),
                get initials() {
                    const letters = this.name.trim().split(/\s+/).filter(Boolean).map((word) => word[0].toUpperCase());
                    return letters.length > 1 ? letters[0] + letters.at(-1) : (letters[0] ?? '?');
                },
            }">
            <div class="flex shrink-0 flex-row items-center gap-3 sm:flex-col sm:gap-2.5">
                <x-account.avatar :initials="auth()->user()->initials()" x-text="initials" class="size-18 text-2xl" />
                <span class="max-w-28 text-xs text-muted-foreground sm:text-center">Initials from your name</span>
            </div>

            <div class="flex max-w-115 flex-1 flex-col gap-4.5">
                <x-account.field id="name" label="Name" icon="ph--user" wire:model="name" x-on:input="name = $event.target.value"
                    name="name" autocomplete="name" maxlength="80" :error="$errors->first('name') ?: null" />

                <x-account.field id="email" label="Email" icon="ph--envelope-simple" trailing-icon="ph--lock-simple"
                    name="email" type="email" :value="auth()->user()->email" readonly
                    hint="Your email is how you sign in, so it can't be changed here. To use another address, sign in with it — it creates a separate account." />
            </div>
        </div>

        <footer class="flex flex-col gap-3 border-t border-border bg-surface px-5 py-3.5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <span class="text-[13px] text-muted-foreground">Changes apply to your team straight away.</span>
            <span class="flex items-center gap-3">
                @if ($saved)
                    <span class="flex items-center gap-1.5 text-[13px] text-emerald-700 dark:text-emerald-400" role="status">
                        <span aria-hidden="true" class="iconify ph--check text-sm"></span>
                        Saved
                    </span>
                @endif
                <x-ui.button type="submit" variant="solid" intent="primary" class="font-medium" wire:loading.attr="disabled" wire:target="save">Save changes</x-ui.button>
            </span>
        </footer>
    </form>

    <div class="mt-4 grid gap-4 md:grid-cols-2">
        <x-account.panel title="Sign-in method">
            <x-slot:actions>
                <x-account.pill tone="success" icon="ph--shield-check">No password</x-account.pill>
            </x-slot:actions>
            <div class="flex items-start gap-3.5">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-[11px] bg-primary/10 text-primary">
                    <span aria-hidden="true" class="iconify ph--magic-wand text-lg"></span>
                </span>
                <div>
                    <p class="text-[14.5px] font-semibold text-title-foreground">Magic link</p>
                    <p class="mt-1 text-[13.5px]/5 text-muted-foreground">
                        A one-time link sent to {{ auth()->user()->email }}. There is no password to leak, reuse or reset.
                    </p>
                </div>
            </div>
        </x-account.panel>

        <x-account.panel title="Session">
            <div class="flex items-center gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-[11px] bg-subtle text-title-foreground">
                    <span aria-hidden="true" class="iconify ph--clock text-lg"></span>
                </span>
                <div>
                    <p class="text-[14.5px] font-semibold text-title-foreground">Signed in on this device</p>
                    <p class="mt-0.5 text-[13.5px] text-muted-foreground">Your CLI tokens keep working after you sign out.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <x-ui.button type="submit" variant="outline" intent="gray" class="gap-1.5 font-medium">
                    <span aria-hidden="true" class="iconify ph--sign-out"></span>
                    Sign out
                </x-ui.button>
            </form>
        </x-account.panel>
    </div>
</x-account.shell>
