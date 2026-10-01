<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureRateLimiting();
    }

    /**
     * Débit de la CLI, compté par jeton et non par IP : une équipe derrière
     * le même NAT ne se gêne pas, et un jeton partagé publiquement plafonne
     * vite. Un projet réel tire quelques dizaines de fichiers à la fois.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('cli', function (Request $request): array {
            $key = hash('sha256', (string) ($request->bearerToken() ?: $request->ip()));

            return [
                Limit::perMinute(60)->by('cli:minute:'.$key),
                Limit::perDay(1000)->by('cli:day:'.$key),
            ];
        });

        // Un agent enchaîne plus d'appels qu'un humain (recherche, lecture,
        // source), d'où un plafond par minute plus haut que la CLI.
        RateLimiter::for('mcp', function (Request $request): array {
            $key = hash('sha256', (string) ($request->bearerToken() ?: $request->ip()));

            return [
                Limit::perMinute(120)->by('mcp:minute:'.$key),
                Limit::perDay(3000)->by('mcp:day:'.$key),
            ];
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
