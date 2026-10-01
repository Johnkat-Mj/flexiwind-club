<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class TemplateController extends Controller
{
    /**
     * Page détail d'un template, avec sa démo interactive.
     */
    public function __invoke(string $template): View
    {
        $templates = config('templates');

        abort_unless(isset($templates[$template]), 404);

        return view('pages.template-detail', [
            'template' => $templates[$template],
            'others' => array_values(array_filter($templates, fn (array $item): bool => $item['key'] !== $template)),
        ]);
    }
}
