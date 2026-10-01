<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class PreviewUiController extends Controller
{
    /**
     * Rend la page isolée d'un block, affichée dans l'iframe de /blocks.
     *
     * Le chemin est libre : /preview-ui/auth/login01 sert la version pro du
     * dépôt pro, /preview-ui/free/auth/login01 la version OSS du dépôt
     * public. Les deux jeux portent les mêmes noms sans être les mêmes blocks.
     */
    public function __invoke(?string $path = null)
    {
        $segments = array_filter(explode('/', trim((string) $path, '/')));

        if ($segments === []) {
            abort(404);
        }

        $view = 'pages-preview.'.implode('.', $segments);

        if (! View::exists($view)) {
            abort(404);
        }

        return view($view, [
            'path' => '/'.implode('/', $segments),
        ]);
    }
}
