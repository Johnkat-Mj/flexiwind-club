<?php

namespace App\Mcp\Servers;

use App\Mcp\Prompts\AddItemPrompt;
use App\Mcp\Resources\SetupGuideResource;
use App\Mcp\Tools\AccountStatusTool;
use App\Mcp\Tools\GetItemTool;
use App\Mcp\Tools\GetSourceTool;
use App\Mcp\Tools\ReadDocsTool;
use App\Mcp\Tools\SearchCatalogTool;
use App\Mcp\Tools\SearchDocsTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

/**
 * Le serveur MCP de Flexiwind, pour les assistants de code (Claude Code,
 * Cursor, VS Code…).
 *
 * Tout est en lecture seule. L'authentification est celle de la CLI — un
 * jeton porteur généré dans /account/tokens — et l'abonnement est revérifié
 * dans chaque outil qui rend du code Pro. Voir routes/ai.php pour les
 * barrières HTTP (origine, taille, débit).
 */
#[Name('Flexiwind')]
#[Version('1.0.0')]
#[Instructions(<<<'MARKDOWN'
    Flexiwind is a library of Blade and Livewire UI components, page blocks and themes for Laravel,
    built on Tailwind CSS v4. Items are installed into the user's project with `php artisan flexi:add`.

    - Find items with search-catalog, then inspect one with get-item before installing it.
    - Items exist in two tiers. Free items install as `flexi:add <name>`. Pro items install as
      `flexi:add @fx/<name>` and need an active Flexiwind Pro subscription; account-status tells you
      whether the connected account has one. The same name can exist in both tiers.
    - Prefer running the install command in the project over writing files from get-source:
      flexi:add also installs dependencies and records the install.
    - Use search-docs and read-docs for props, variants and usage examples.
    - Never ask the user to paste a token or any secret into the conversation.
    MARKDOWN)]
class FlexiwindServer extends Server
{
    protected array $tools = [
        SearchCatalogTool::class,
        GetItemTool::class,
        GetSourceTool::class,
        SearchDocsTool::class,
        ReadDocsTool::class,
        AccountStatusTool::class,
    ];

    protected array $resources = [
        SetupGuideResource::class,
    ];

    protected array $prompts = [
        AddItemPrompt::class,
    ];
}
