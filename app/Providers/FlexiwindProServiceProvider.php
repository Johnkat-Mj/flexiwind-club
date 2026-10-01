<?php

namespace App\Providers;

use App\Models\User;
use App\Support\HighlightedCodeRenderer;
use Flexiwind\Docs\ArtifactRegistry;
use Flexiwind\Docs\ArtifactSource;
use Flexiwind\Docs\BlockRegistry;
use Flexiwind\Docs\Contracts\CodeHighlighter;
use Flexiwind\Docs\Tier;
use Flexiwind\Docs\TierResolver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Ce dépôt est à la fois le produit premium et le site qui le vend.
 * Ce provider câble les deux au docs-kit public.
 */
class FlexiwindProServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Le docs-kit ne connaît pas Shiki : c'est l'app qui fournit son moteur.
        $this->app->bind(CodeHighlighter::class, fn (): CodeHighlighter => new class implements CodeHighlighter
        {
            public function highlight(string $code, string $language = 'blade'): string
            {
                return HighlightedCodeRenderer::render($code, $language);
            }
        });
    }

    public function boot(): void
    {
        $this->resolveTierFromSubscription();

        $registry = $this->app->make(ArtifactRegistry::class);

        // ---- Le produit : artefacts premium, jamais publiés ----------------
        // Parité de résolution : <x-pro.select />, <x-blocks-pro.… />
        View::addLocation(base_path('registry-pro/views'));

        $registry->add(new ArtifactSource(
            name: 'flexiwind-pro',
            tier: Tier::Pro,
            root: base_path('registry-pro/views'),
            examplePrefix: 'examples-pro',
            componentPrefix: 'pro',
            priority: 60,
        ));

        // Les payloads de blocks premium (onglet « Code » de /blocks).
        $this->app->make(BlockRegistry::class)->add(resource_path('pro-club'), Tier::Pro);

        // ---- Le site : ses propres vues, en priorité maximale --------------
        // Permet de surcharger un exemple du repo public sans le forker.
        $registry->add(new ArtifactSource(
            name: 'site',
            tier: Tier::Free,
            root: resource_path('views'),
            examplePrefix: 'examples',
            componentPrefix: 'ui',
            priority: 100,
        ));

        // Démos "club" historiques, en attendant leur passage dans registry-pro.
        $registry->add(new ArtifactSource(
            name: 'site-club',
            tier: Tier::Pro,
            root: resource_path('views'),
            examplePrefix: 'demo',
            componentPrefix: 'club',
            priority: 90,
        ));
    }

    /**
     * Le palier d'un visiteur du site pro, c'est son abonnement.
     *
     * Une seule ligne branche tout le verrouillage déjà en place : les
     * exemples pro de la documentation, l'onglet « Code » des blocks pro et
     * les payloads servis à la CLI passent tous par Tier::current().
     */
    private function resolveTierFromSubscription(): void
    {
        TierResolver::using(static function (): Tier {
            $user = Auth::user();

            return $user instanceof User && $user->hasProAccess() ? Tier::Pro : Tier::Free;
        });
    }
}
