@php
    $links = [
        [
            'text' => 'Templates',
            'href' => '/templates',
        ],
        [
            'text' => 'Blocks',
            'href' => '/blocks',
        ],
        [
            'text' => 'Components',
            'href' => '/components/button',
        ],
    ];
@endphp

<footer class="px-5 sm:px-10 xl:pl-16 xl:pr-0 mt-1 pb-4">
    <span class="border-t border-border pt-6 flex w-full"></span>
    <div class="px-4 py-6 sm:px-6 pt4 flex flex-col gap-5 bg-gray-50/60 dark:bg-gray-900/30 border border-border rounded-ui">
        <div class="w-full flex flex-col md:flex-row gap-6 md:justify-between items-center text-sm">
            <div class="text-sm text-foreground">
                Published under 
                <x-atoms.ui-link 
                    href="https://github.com/unoforge/flexiwind"
                    aria-label="MIT License"
                    class="text-muted-foreground"
                >
                    MIT License
                </x-atoms.ui-link>
            </div>
            <ul class="flex flex-wrap items-center gap-x-4 gap-y-2">
                @foreach ($links as $link)
                    <li>
                        <x-atoms.ui-link
                            aria-label="Link to {{ $link['text'] }}"
                            href="{{ $link['href'] }}"
                            class="text-muted-foreground hover:text-title-foreground  flex items-center gap-x-0.5"
                        >
                            {{ $link['text'] }}
                            @if (!Str::startsWith($link['href'], ['/','#']))
                                <span aria-hidden="true" class="flex iconify ph--arrow-up-right text-xs"></span>
                            @endif
                        </x-atoms.ui-link>
                    </li>
                @endforeach
            </ul>
            <div class="flex">
                <x-atoms.social-links />
            </div>
        </div>
        <div class="text-sm border-t border-border bg-subtle px-4 py-2 rounded-lg text-muted-foreground text-center">
            &copy; Flexiwind {{ Date('Y') }}. By 
            <x-atoms.ui-link
                href="https://x.com/johnkat_Mj"
                class="underline underline-offset-2 text-title-foreground "
            >
                Johnkat MJ.
            </x-atoms.ui-link>
        </div>
    </div>
</footer>