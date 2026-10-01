@php
    $columns = [
        'Product' => [
            ['Components', '/components'],
            ['Blocks', route('blocks.list')],
            ['Templates', route('pages.templates')],
            ['Charts', route('charts')],
            ['Pricing', route('pricing')],
        ],
        'Resources' => [
            ['Documentation', '/docs/introduction'],
            ['Examples', route('examples')],
            ['Playground', route('playground')],
            ['Changelog', route('changelog')],
            ['GitHub', 'https://github.com/unoforge/flexiwind'],
        ],
        'Account' => [
            ['Sign in', route('login')],
            ['CLI tokens', route('account.tokens')],
            ['Subscription', route('account.subscription')],
        ],
    ];
@endphp

<footer class="relative">
    <x-site.container class="pt-14 pb-10 text-sm text-muted-foreground">
        <div class="flex flex-col gap-10 md:flex-row md:justify-between">
            <div class="max-w-80">
                <a href="/" wire:navigate aria-label="Flexiwind home" class="flex items-center gap-2.5 text-title-foreground">
                    <x-atoms.logo />
                    <span class="font-display text-lg font-semibold tracking-[-0.02em]">Flexiwind</span>
                </a>
                <p class="mt-3.5 leading-relaxed">
                    Blade and Livewire components you install with one command and own for good.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-10 sm:grid-cols-3 sm:gap-12">
                @foreach ($columns as $heading => $items)
                    <div class="flex flex-col gap-2.5 sm:w-35">
                        <span class="font-semibold text-title-foreground">{{ $heading }}</span>
                        @foreach ($items as [$label, $href])
                            <a href="{{ $href }}" @if (str_starts_with($href, '/') || str_starts_with($href, url('/'))) wire:navigate @endif
                                class="w-max transition-colors hover:text-title-foreground">{{ $label }}</a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-12 flex justify-between border-t border-border pt-5.5 text-[13px]">
            <span>&copy; {{ date('Y') }} Flexiwind</span>
            <span>Made for Laravel</span>
        </div>
    </x-site.container>
</footer>
