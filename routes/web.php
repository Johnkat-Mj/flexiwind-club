<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\PreviewUiController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\TemplateController;
use App\Livewire\PagePreview;
use Flexiwind\Livewire\MarkdownDocsPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home-page', [
        'allBlocks' => config('blocks'),
    ]);
})->name('pages.home-page');
Route::view('/templates', 'pages.templates')->name('pages.templates');
Route::get('/templates/{template}', TemplateController::class)->name('templates.show');

Route::view('/examples', 'pages.examples')->name('examples');
Route::view('/charts', 'pages.charts')->name('charts');
Route::view('/changelog', 'pages.changelog')->name('changelog');
Route::view('/playground', 'pages.playground')->name('playground');
Route::view('/playground/preview', 'pages.playground-preview')->name('playground.preview');

/*
|--------------------------------------------------------------------------
| Documentation
|--------------------------------------------------------------------------
| Le contenu vient des fichiers Markdown du dépôt public. Le chemin de la
| requête EST le slug : /components/plugins/chart -> content/components/
| plugins/chart.md. Un seul composant sert toutes les sections ; le cookbook
| est une section autonome (config flexiwind-docs.standalone_sections).
*/
Route::redirect('/docs', '/docs/introduction');
Route::livewire('/docs/{path?}', MarkdownDocsPage::class)->where('path', '.*')->name('documentation');
// Le cookbook a quitté /components : les anciens liens gardent leur cible.
Route::get('/components/cookbook/{path?}', fn (?string $path = null) => redirect('/cookbook'.($path ? '/'.$path : ''), 301))
    ->where('path', '[a-z0-9\-/]+');
Route::livewire('/components/{path?}', MarkdownDocsPage::class)->where('path', '.*')->name('components');

// Les premières pages du cookbook, remplacées par des recettes complètes.
Route::permanentRedirect('/cookbook/modal-forms', '/cookbook/recipes/edit-in-a-modal');
Route::permanentRedirect('/cookbook/confirmation-dialogs', '/cookbook/recipes/delete-with-undo');
Route::permanentRedirect('/cookbook/form-snippets', '/cookbook/tips/livewire-forms');

// Section autonome : même rendu que la doc, mais sa propre sidebar et son propre layout.
Route::livewire('/cookbook/{path?}', MarkdownDocsPage::class)->where('path', '.*')->name('cookbook');

Route::livewire('/blocks', 'pages::blocks.list-page')->name('blocks.list');
Route::livewire('/blocks/{blockCategory}/{blockName}', 'pages::blocks.group-view')->name('blocks.show');
Route::livewire('/preview-blocks/{group}/{preview}', PagePreview::class)->name('preview.grouped');

Route::get('/preview-ui/{path}', PreviewUiController::class)->where('path', '.*')->name('preview.ui');

/*
|--------------------------------------------------------------------------
| Compte, abonnement, jetons
|--------------------------------------------------------------------------
| L'authentification se fait par lien à usage unique. Il n'y a pas de mot de
| passe à voler, donc pas de credential stuffing possible.
*/

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'app-auth::login')->name('login');
});

// `signed` rejette une URL retouchée avant même de toucher la base ;
// `throttle` empêche de balayer des identifiants de liens.
Route::get('/auth/link/{link}/{token}', [MagicLinkController::class, 'show'])
    ->middleware(['signed', 'throttle:20,1'])
    ->whereNumber('link')
    ->name('auth.link');

Route::post('/logout', [MagicLinkController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::livewire('/account', 'profile::index')->name('account');
    Route::livewire('/account/profile', 'profile::profile')->name('account.profile');
    Route::livewire('/account/subscription', 'profile::subscription')->name('account.subscription');
    Route::livewire('/account/tokens', 'profile::tokens')->name('account.tokens');
});

Route::livewire('/pricing', 'pages::pricing')->name('pricing');

Route::livewire('/checkout/{plan}', 'pages::checkout')
    ->middleware('auth')
    ->name('checkout.show');

Route::get('/team/invitation/{invitation}/{token}', [TeamInvitationController::class, 'show'])
    ->middleware(['signed', 'throttle:20,1'])
    ->whereNumber('invitation')
    ->name('team.invitation');

Route::post('/team/invitation/{invitation}/{token}', [TeamInvitationController::class, 'accept'])
    ->middleware(['signed', 'throttle:20,1'])
    ->whereNumber('invitation')
    ->name('team.invitation.accept');
