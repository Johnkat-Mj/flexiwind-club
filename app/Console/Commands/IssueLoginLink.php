<?php

namespace App\Console\Commands;

use App\Auth\MagicLink;
use App\Models\LoginLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Imprime un lien de connexion utilisable tel quel.
 *
 * En local le mailer écrit dans les logs : le lien s'y trouve sous forme de
 * HTML, donc avec `&amp;` dans le href. Copié verbatim, il devient un
 * paramètre `amp;signature` et la signature échoue. Cette commande évite
 * complètement ce détour.
 */
class IssueLoginLink extends Command
{
    protected $signature = 'flexi:login-link {email : Address to sign in as}';

    protected $description = 'Print a ready-to-use magic sign-in link (local only)';

    public function handle(MagicLink $magicLink): int
    {
        // Contourner la boîte mail, c'est contourner la preuve de possession :
        // réservé aux environnements de développement.
        if (app()->isProduction()) {
            $this->error('Not available in production.');

            return self::FAILURE;
        }

        $email = Str::lower(trim((string) $this->argument('email')));

        if (Validator::make(['email' => $email], ['email' => 'required|email:rfc'])->fails()) {
            $this->error("[{$email}] is not a valid email address.");

            return self::FAILURE;
        }

        $link = LoginLink::issue($email);

        $this->newLine();
        $this->line('<fg=gray>Sign in as</> '.$email);
        $this->line($magicLink->url($link));
        $this->newLine();
        $this->line('<fg=gray>Valid '.LoginLink::TTL_MINUTES.' minutes, once. Host must match APP_URL ('.config('app.url').').</>');

        return self::SUCCESS;
    }
}
