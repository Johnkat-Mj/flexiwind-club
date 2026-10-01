<?php

/*
|--------------------------------------------------------------------------
| Changelog
|--------------------------------------------------------------------------
| Les entrées de la page /changelog, au format Keep a Changelog. `visual`
| nomme l'illustration rendue par resources/views/components/changelog.
*/

return [
    [
        'version' => 'Unreleased',
        'date' => 'September 2026',
        'title' => 'Pro accounts, seats and CLI tokens',
        'summary' => 'Sign in with a magic link, pick a plan, invite your team, and give the CLI its own tokens — revoked the moment a seat is freed.',
        'tags' => ['pro', 'cli'],
        'visual' => 'pro',
        'changes' => [
            'Added' => [
                'Magic-link sign-in. There is no password to leak or reset.',
                'Three plans: Solo yearly, Solo lifetime and Team lifetime with five seats.',
                'Personal CLI tokens, shown once, revocable any time.',
                'Registry API for the CLI: GET /api/v1/registry/{name}.',
            ],
            'Changed' => [
                'Pro examples stay visible in the docs; only their source is locked.',
                'Pro blocks show a locked Code tab until you subscribe.',
            ],
        ],
    ],
    [
        'version' => 'Unreleased',
        'date' => 'September 2026',
        'title' => 'Documentation rebuilt on Markdown',
        'summary' => 'Every page is now a Markdown file anyone can improve on GitHub, with live previews and highlighted code.',
        'tags' => ['docs'],
        'visual' => 'docs',
        'changes' => [
            'Added' => [
                '66 pages in Markdown, editable from GitHub.',
                'Syntax highlighting with Shiki.',
                "Sidebar and pagination generated from each page's front matter.",
            ],
            'Fixed' => [
                'Missing code in the Modal usage section.',
                'Empty installation terminals.',
            ],
        ],
    ],
    [
        'version' => 'v1.0.0',
        'date' => '[DATE]',
        'title' => 'Introducing Flexiwind v1',
        'summary' => 'The first stable release: components and blocks you install with one command and own for good.',
        'tags' => ['components', 'blocks', 'cli'],
        'visual' => 'v1',
        'changes' => [
            'Added' => [
                '98 blocks across 25 groups — 51 free, 47 in Pro.',
                '39 open-source components.',
                'The flexi CLI: flexi:init, flexi:add and flexi:list.',
                'Light and dark themes driven by tokens.',
            ],
        ],
    ],
];
