<?php

namespace App\Mcp\Resources;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\MimeType;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Uri;
use Laravel\Mcp\Server\Resource;

#[Name('setup-guide')]
#[Uri('flexiwind://guides/setup')]
#[MimeType('text/markdown')]
#[Description('How to set up a Laravel project so `php artisan flexi:add` can install free and Pro Flexiwind items. Read it before installing anything in a project that has no flexiwind.yaml yet.')]
class SetupGuideResource extends Resource
{
    public function handle(Request $request): Response
    {
        $registry = url('/api/v1/pro').'/{name}';
        $tokens = route('account.tokens');

        return Response::text(<<<MARKDOWN
            # Setting up Flexiwind in a Laravel project

            ## 1. Initialise the project (once)

            ```bash
            composer require --dev unoforge/flexiwind-cli
            php artisan flexi:init
            ```

            `flexi:init` writes `flexiwind.yaml`, installs Tailwind CSS v4 and the base theme.

            ## 2. Free items

            ```bash
            php artisan flexi:add button
            php artisan flexi:add login01
            ```

            ## 3. Pro items (`@fx/`)

            Pro items need an active Flexiwind Pro subscription and a CLI token.

            1. The user generates a token at {$tokens}. Never ask them to paste it into the chat:
               tell them to put it in the project's `.env` themselves.

               ```dotenv
               FLEXIWIND_TOKEN=fx_…
               ```

            2. Declare the Pro registry in `flexiwind.yaml`, next to the existing registries:

               ```yaml
               registries:
                 '@fx':
                   url: {$registry}
                   headers:
                     Authorization: 'Bearer \${FLEXIWIND_TOKEN}'
               ```

            3. Install with the `@fx/` prefix:

               ```bash
               php artisan flexi:add @fx/login01
               ```

            `flexi:add` writes the files listed by `get-item`, installs the registry dependencies it
            needs, and prints any Composer or npm packages to install.
            MARKDOWN);
    }
}
