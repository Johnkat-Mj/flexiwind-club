<?php

use Illuminate\Support\Facades\Process;

/*
 * Chaque thème du registre doit avoir une palette de charts lisible : couleurs
 * voisines distinctes, y compris pour les daltonismes, en clair et en sombre.
 * La vérification vit dans flexiwind/bin/chart-palettes.mjs, qui sait aussi
 * recalculer une palette : `node bin/chart-palettes.mjs theme-nom`.
 */
it('gives every theme a readable chart palette', function (): void {
    if (Process::run('node --version')->failed()) {
        $this->markTestSkipped('Node.js is required to check the chart palettes.');
    }

    $result = Process::path(base_path('../flexiwind'))->run('node bin/chart-palettes.mjs --check');

    expect($result->successful())->toBeTrue(
        "Some chart palettes fail. Run `node bin/chart-palettes.mjs <theme>` in flexiwind/ to fix them.\n".$result->output(),
    );
});
