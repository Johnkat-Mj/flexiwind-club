@props([])

@php

    $repositoryUrl = config('base.githubRepoUrl');
    $contribLinks = [
        [
            'href' => '/report-issue',
            'text' => 'Report an issue',
            'icon' => 'iconify ph--chats-circle',
        ]
    ];
@endphp

<div class="mb-2 pt-3 border-t border-border-strong border-dashed">
    <h2 class="text-sm font-semibold hidden lg:flex text-subtitle">
        Club Resources
    </h2>

    <nav aria-label="Contribute Links" class="mt-3 flex flex-col">
        <ol class="flex flex-col space-y-2 text-muted-foreground text-sm">
            @foreach ($contribLinks as $link)
                <li class="flex">
                    <a href="{{ $link['href'] }}" target="_blank" rel="noopener noreferrer"
                        aria-label="Link to {{ $link['text'] }}"
                        class="flex items-center gap-x-2 hover:text-title-foreground  ease-linear duration-200">
                        <span class="flex">
                            <span aria-hidden="true" class="flex mr-2 {{ $link['icon'] }}"></span>
                            <span class="flex">{{ $link['text'] }}</span>
                        </span>
                        <span aria-hidden="true" class="flex iconify ph--arrow-square-out text-[11px]"></span>
                    </a>
                </li>
            @endforeach
        </ol>

    </nav>
</div>
