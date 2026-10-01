<?php

use App\Http\Middleware\AuthenticateApiToken;
use App\Http\Middleware\GuardMcpRequests;
use App\Mcp\Servers\FlexiwindServer;
use Laravel\Mcp\Facades\Mcp;

/*
|--------------------------------------------------------------------------
| Serveur MCP
|--------------------------------------------------------------------------
| Même jeton que la CLI (Authorization: Bearer fx_…), mêmes règles : un
| jeton révoqué ou un siège retiré coupe l'accès au prochain appel.
|
| Ordre des barrières : origine et taille d'abord (rien à décoder), puis le
| jeton, puis le débit par jeton. Aucune session, aucun cookie : ces routes
| sont hors du groupe `web`, donc sans CSRF à contourner.
*/

Mcp::web('/mcp', FlexiwindServer::class)
    ->middleware([GuardMcpRequests::class, AuthenticateApiToken::class, 'throttle:mcp'])
    ->name('mcp');
