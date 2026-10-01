<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ProRegistryController;
use App\Http\Controllers\Api\RegistryController;
use App\Http\Middleware\AuthenticateApiToken;
use App\Registry\ProRegistry;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API de la CLI
|--------------------------------------------------------------------------
| Sans état : chaque appel présente un jeton porteur, et l'abonnement est
| revérifié à chaque fois. Le débit est limité par jeton (voir le limiteur
| `cli` dans AppServiceProvider) pour qu'un jeton volé ne serve pas à
| aspirer le catalogue.
*/

Route::middleware([AuthenticateApiToken::class, 'throttle:cli'])
    ->prefix('v1')
    ->group(function (): void {
        Route::get('/me', AccountController::class)->name('api.me');

        // Le registre `@fx` de flexi:add. Le `.json` final est accepté pour
        // les configurations qui l'ajoutent par habitude.
        Route::get('/pro', [ProRegistryController::class, 'index'])->name('api.pro.index');
        Route::get('/pro/{name}', [ProRegistryController::class, 'show'])
            ->where('name', ProRegistry::NAME_PATTERN.'(\.json)?')
            ->name('api.pro.show');

        Route::get('/registry/{name}', RegistryController::class)
            ->where('name', '(@fx/)?[A-Za-z0-9-]+')
            ->name('api.registry');
    });
