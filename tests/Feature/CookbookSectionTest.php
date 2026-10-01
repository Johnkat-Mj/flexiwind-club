<?php

use Flexiwind\Docs\Navigation;

it('serves the cookbook under its own prefix', function (string $path): void {
    $this->get($path)->assertOk()->assertSee('Cookbook');
})->with([
    '/cookbook',
    '/cookbook/recipes/edit-in-a-modal',
    '/cookbook/recipes/delete-with-undo',
    '/cookbook/recipes/country-then-city',
    '/cookbook/recipes/assign-with-search',
    '/cookbook/tips/livewire-forms',
    '/cookbook/tips/modals-and-feedback',
]);

it('sends the old cookbook addresses to the new ones', function (): void {
    $this->get('/components/cookbook')->assertRedirect('/cookbook')->assertStatus(301);
    $this->get('/components/cookbook/modal-forms')->assertRedirect('/cookbook/modal-forms')->assertStatus(301);
    $this->get('/cookbook/modal-forms')->assertRedirect('/cookbook/recipes/edit-in-a-modal')->assertStatus(301);
    $this->get('/cookbook/confirmation-dialogs')->assertRedirect('/cookbook/recipes/delete-with-undo');
    $this->get('/cookbook/form-snippets')->assertRedirect('/cookbook/tips/livewire-forms');
});

it('gives the cookbook its own sidebar', function (): void {
    $groups = app(Navigation::class)->groups('cookbook');
    $paths = collect($groups)->flatMap(fn (array $group): array => array_column($group['items'], 'path'));

    expect(array_column($groups, 'label'))->toBe(['Getting Started', 'Recipes', 'Tips & snippets'])
        ->and($paths->every(fn (string $path): bool => str_starts_with($path, '/cookbook')))->toBeTrue();
});

it('keeps the cookbook out of the docs and components sidebar', function (): void {
    $paths = collect(app(Navigation::class)->groups())->flatMap(fn (array $group): array => array_column($group['items'], 'path'));

    expect($paths)->not->toBeEmpty()
        ->and($paths->contains(fn (string $path): bool => str_starts_with($path, '/cookbook')))->toBeFalse()
        ->and(config('sidebar'))->toBe(app(Navigation::class)->groups());
});

it('keeps previous and next inside each section', function (): void {
    $navigation = app(Navigation::class);
    $cookbook = $navigation->flattened('cookbook');
    $common = $navigation->flattened();

    expect($navigation->neighbours($cookbook[0]['path'])['prev'])->toBeNull()
        ->and($navigation->neighbours(end($cookbook)['path'])['next'])->toBeNull()
        ->and($navigation->neighbours(end($common)['path'])['next'])->toBeNull();
});

it('renders the cookbook in its own layout', function (): void {
    $navigation = app(Navigation::class);

    expect($navigation->sectionOf('/cookbook/modal-forms'))->toBe('cookbook')
        ->and($navigation->sectionOf('/components/button'))->toBeNull()
        ->and($navigation->layoutFor('/cookbook'))->toBe('layouts::cookbook')
        ->and($navigation->layoutFor('/docs/introduction'))->toBe('layouts::docs');
});

it('lists only cookbook pages in the cookbook page sidebar', function (): void {
    $this->get('/cookbook/tips/livewire-forms')
        ->assertOk()
        ->assertSee('Delete, then undo')
        ->assertDontSee('/components/listbox', false);
});
