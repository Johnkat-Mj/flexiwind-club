<?php

use App\Providers\AppServiceProvider;
use App\Providers\FlexiwindProServiceProvider;
use Flexiwind\FlexiwindServiceProvider;

return [
    AppServiceProvider::class,

    // Dépôt public (unoforge/flexiwind) : contenu, artefacts free, moteur de docs.
    FlexiwindServiceProvider::class,

    // Ce dépôt : artefacts premium + jonction avec le docs-kit.
    FlexiwindProServiceProvider::class,
];
