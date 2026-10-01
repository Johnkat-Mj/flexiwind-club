<?php

use Illuminate\Support\Facades\File;

it('serves every documentation page', function (): void {
    $root = base_path('../flexiwind/content');
    $failures = [];

    foreach (File::allFiles($root) as $file) {
        if ($file->getExtension() !== 'md') {
            continue;
        }

        $slug = str_replace('.md', '', $file->getRelativePathname());
        $status = $this->get('/'.$slug)->getStatusCode();

        if ($status !== 200) {
            $failures[$slug] = $status;
        }
    }

    expect($failures)->toBe([]);
});

it('serves every block group and every block preview', function (): void {
    $failures = [];

    foreach (config('blocks') as $category => $groups) {
        foreach ($groups as $key => $group) {
            $status = $this->get("/blocks/{$category}/{$key}")->getStatusCode();

            if ($status !== 200) {
                $failures["group:{$category}/{$key}"] = $status;
            }

            foreach ($group['blocks'] as $block) {
                $status = $this->get($block['preview'])->getStatusCode();

                if ($status !== 200) {
                    $failures["preview:{$block['name']}"] = $status;
                }
            }
        }
    }

    expect($failures)->toBe([]);
});

it('serves the public pages', function (string $path): void {
    $this->get($path)->assertOk();
})->with([
    '/', '/blocks', '/templates', '/templates/crm', '/templates/starter', '/pricing', '/login',
    '/examples', '/charts', '/changelog', '/playground',
    '/playground/preview?scene=components', '/playground/preview?scene=dashboard', '/playground/preview?scene=auth',
]);

it('returns a 404 for an unknown template', function (): void {
    $this->get('/templates/unknown')->assertNotFound();
});

it('groups blocks, components, examples and charts under one menu item', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSeeText('Blocks & Components')
        ->assertSee(route('examples'))
        ->assertSee(route('charts'))
        ->assertSee(route('playground'));
});
