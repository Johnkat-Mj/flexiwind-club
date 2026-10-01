<?php

use App\Models\ApiToken;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    /** Au-delà, c'est probablement un script, pas un développeur. */
    private const MAX_ACTIVE_TOKENS = 20;

    /** Créations autorisées par fenêtre de dix minutes. */
    private const CREATIONS_PER_WINDOW = 10;

    #[Validate(['required', 'string', 'min:2', 'max:60', 'regex:/^[\pL\pN][\pL\pN .,_()\/@#-]*$/u'], message: [
        'regex' => 'Use letters, numbers, spaces and simple punctuation.',
    ])]
    public string $name = '';

    /**
     * Secret en clair. #[Locked] pour qu'il ne puisse pas être injecté depuis
     * le navigateur, et effacé dès l'action suivante : il ne traîne pas dans
     * les snapshots Livewire au-delà de l'écran où on le montre.
     */
    #[Locked]
    public ?string $justCreated = null;

    #[Locked]
    public ?string $justCreatedName = null;

    public ?string $error = null;

    /**
     * Jeton dont la révocation attend confirmation. Simple affichage :
     * revoke() refait la recherche depuis les jetons de l'utilisateur.
     */
    public ?int $confirmingRevoke = null;

    public function create(): void
    {
        $this->validate();

        $user = auth()->user();
        $rateKey = 'token-create:'.$user->id;

        if (RateLimiter::tooManyAttempts($rateKey, self::CREATIONS_PER_WINDOW)) {
            $this->error = 'Too many tokens created in a short time. Try again in a few minutes.';

            return;
        }

        if ($user->apiTokens()->active()->count() >= self::MAX_ACTIVE_TOKENS) {
            $this->error = 'You already have the maximum number of active tokens. Revoke one first.';

            return;
        }

        RateLimiter::hit($rateKey, 600);

        $token = ApiToken::issue($user, trim($this->name));

        $this->justCreated = $token->plainText;
        $this->justCreatedName = $token->name;
        $this->error = null;
        $this->name = '';
    }

    public function askRevoke(int $tokenId): void
    {
        $this->confirmingRevoke = auth()->user()->apiTokens()->active()->whereKey($tokenId)->exists()
            ? $tokenId
            : null;
    }

    public function cancelRevoke(): void
    {
        $this->confirmingRevoke = null;
    }

    public function revoke(): void
    {
        // La requête part TOUJOURS de l'utilisateur connecté : un identifiant
        // qui ne lui appartient pas ne trouve simplement rien.
        $tokenId = $this->confirmingRevoke;
        $this->confirmingRevoke = null;

        $token = $tokenId === null ? null : auth()->user()->apiTokens()->whereKey($tokenId)->first();

        if ($token === null) {
            return;
        }

        $token->revoke();

        if ($token->name === $this->justCreatedName) {
            $this->dismissSecret();
        }
    }

    public function dismissSecret(): void
    {
        $this->justCreated = null;
        $this->justCreatedName = null;
    }

    public function with(): array
    {
        $user = auth()->user();

        // Les jetons révoqués restent visibles un mois, le temps de
        // comprendre pourquoi une machine a cessé de fonctionner.
        $tokens = $user->apiTokens()
            ->where(fn ($query) => $query->whereNull('revoked_at')->orWhere('revoked_at', '>', now()->subDays(30)))
            ->orderByRaw('revoked_at IS NOT NULL')
            ->latest()
            ->get();

        return [
            'tokens' => $tokens,
            'activeCount' => $tokens->whereNull('revoked_at')->count(),
            'maxTokens' => self::MAX_ACTIVE_TOKENS,
            'hasProAccess' => $user->hasProAccess(),
            'revoking' => $this->confirmingRevoke ? $tokens->firstWhere('id', $this->confirmingRevoke) : null,
        ];
    }
};
?>

<x-account.shell title="CLI tokens" description="Tokens let the Flexiwind CLI pull Pro components into your projects.">
    @if (! $hasProAccess)
        <x-account.notice class="mb-4 items-center">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <span>You can create tokens now, but they only unlock Pro components while a subscription is active.</span>
                <x-ui.button href="{{ route('pricing') }}" wire:navigate variant="outline" intent="gray" size="sm" class="shrink-0 font-medium text-[13px]">See the plans</x-ui.button>
            </div>
        </x-account.notice>
    @endif

    @if ($justCreated)
        <section class="mb-4 flex flex-col gap-3.5 rounded-2xl border border-emerald-600/35 bg-emerald-600/6 p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex gap-3">
                    <span class="flex size-9 shrink-0 items-center justify-center rounded-[10px] bg-emerald-600/16 text-emerald-700 dark:text-emerald-400">
                        <span aria-hidden="true" class="iconify ph--check-circle text-lg"></span>
                    </span>
                    <div>
                        <p class="text-[15px] font-semibold text-title-foreground">Token “{{ $justCreatedName }}” created</p>
                        <p class="mt-0.5 text-[13.5px] text-muted-foreground">Copy it now — for your safety it is never shown again.</p>
                    </div>
                </div>
                <x-ui.button type="button" wire:click="dismissSecret" variant="outline" intent="gray" size="sm" class="shrink-0 self-start font-medium text-[13px]">I saved it</x-ui.button>
            </div>
            <div x-data="copyText(@js($justCreated))"
                class="flex h-11 items-center justify-between gap-3 rounded-[10px] bg-code pr-1.5 pl-3.5 font-mono text-[13px] text-code-foreground">
                <span class="min-w-0 truncate">{{ $justCreated }}</span>
                <button type="button" x-on:click="copy()"
                    class="h-8 shrink-0 cursor-pointer rounded-lg bg-white/10 px-3 text-[12.5px] font-medium text-white transition-colors hover:bg-white/15"
                    x-text="copied ? 'Copied' : 'Copy'">Copy</button>
            </div>
            <div>
                <p class="text-[12.5px] font-medium text-title-foreground">Then add it to the project's .env</p>
                <x-account.code-line :copy="'FLEXIWIND_TOKEN=' . $justCreated" class="mt-1.5">FLEXIWIND_TOKEN={{ \Illuminate\Support\Str::limit($justCreated, 16) }}</x-account.code-line>
            </div>
        </section>
    @endif

    <x-account.panel title="New token" description="Name it after the machine or project that will use it.">
        <x-slot:actions>
            <span class="text-[13px] whitespace-nowrap text-muted-foreground">{{ $activeCount }} of {{ $maxTokens }} active</span>
        </x-slot:actions>

        @if ($error)
            <x-account.notice tone="danger" class="mb-4">{{ $error }}</x-account.notice>
        @endif

        <form wire:submit="create" class="flex flex-col gap-2.5 sm:flex-row sm:items-end">
            <div class="flex-1">
                <x-account.field id="token-name" label="Token name" icon="ph--key" wire:model="name" name="token-name" maxlength="60"
                    autocomplete="off" placeholder="Laptop, CI, client project…" :invalid="$errors->has('name')" described-by="token-name-error" />
            </div>
            <x-ui.button type="submit" variant="solid" intent="primary" class="h-10 gap-1.5 font-medium" wire:loading.attr="disabled" wire:target="create">
                <span aria-hidden="true" class="iconify ph--plus"></span>
                Generate
            </x-ui.button>
        </form>
        @error('name')
            <p id="token-name-error" class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
        @enderror
    </x-account.panel>

    <x-account.panel title="Your tokens" description="A revoked token stops working at once, everywhere." padding="p-0" class="mt-4">
        @if ($tokens->isEmpty())
            <p class="px-6 py-10 text-center text-sm text-muted-foreground">No token yet. Generate one to use the CLI.</p>
        @else
            <div class="hidden h-10 grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)_minmax(0,1fr)_7rem] items-center gap-4 border-b border-border bg-surface px-6 text-[12.5px] font-medium text-muted-foreground sm:grid">
                <span>Name</span><span>Created</span><span>Last used</span><span></span>
            </div>
            <ul>
                @foreach ($tokens as $token)
                    @php
                        $isNew = ! $token->isRevoked() && $token->name === $justCreatedName && $token->created_at->gt(now()->subMinutes(10));
                    @endphp
                    <li wire:key="token-{{ $token->id }}" @class([
                        'grid grid-cols-[minmax(0,1fr)_auto] items-center gap-x-4 gap-y-1 border-t border-border/60 px-5 py-3.5 first:border-t-0 sm:min-h-17 sm:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)_minmax(0,1fr)_7rem] sm:px-6',
                        'opacity-55' => $token->isRevoked(),
                    ])>
                        <div class="min-w-0">
                            <p class="flex items-center gap-2 text-[14.5px] font-medium text-title-foreground">
                                <span class="truncate">{{ $token->name }}</span>
                                @if ($token->isRevoked())
                                    <x-account.pill tone="danger" class="h-5 text-[11px]">Revoked</x-account.pill>
                                @elseif ($isNew)
                                    <x-account.pill tone="primary" class="h-5 text-[11px]">New</x-account.pill>
                                @else
                                    <x-account.pill tone="success" class="h-5 text-[11px]">Active</x-account.pill>
                                @endif
                            </p>
                            <p class="mt-0.5 font-mono text-xs text-muted-foreground">{{ $token->maskedLabel() }}</p>
                        </div>
                        <p class="order-last col-span-2 text-[13px] text-muted-foreground sm:order-none sm:col-span-1 sm:text-[13.5px] sm:text-foreground">
                            <span class="sm:hidden">Created </span>{{ $token->created_at->isoFormat('ll') }}
                        </p>
                        <p class="order-last col-span-2 text-[13px] text-muted-foreground sm:order-none sm:col-span-1 sm:text-[13.5px] sm:text-foreground">
                            <span class="sm:hidden">Last used </span>{{ $token->last_used_at?->diffForHumans() ?? 'Never used' }}
                        </p>
                        <div class="row-start-1 flex justify-end sm:row-auto">
                            @unless ($token->isRevoked())
                                <x-ui.button type="button" wire:click="askRevoke({{ $token->id }})" variant="soft" intent="danger" size="sm" class="font-medium text-[13px]">
                                    Revoke
                                </x-ui.button>
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-account.panel>

    <x-account.confirm :show="$revoking !== null" :title="'Revoke “' . ($revoking?->name ?? '') . '”?'" icon="ph--key"
        cancel="cancelRevoke" confirm="revoke" confirm-label="Revoke token">
        Any machine using this token stops pulling Pro components immediately. You can generate a new one at any time.
    </x-account.confirm>
</x-account.shell>
