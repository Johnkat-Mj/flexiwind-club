<?php

use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

// ---------------------------------------------------------------- edit in a modal

it('fills the form and opens the modal for the row being edited', function (): void {
    Livewire::test('cookbook-edit-member')
        ->call('edit', 3)
        ->assertSet('editingId', 3)
        ->assertSet('name', 'Sarah Chen')
        ->assertSet('role', 'member')
        ->assertDispatched('modal:edit-member:open');
});

it('saves the row, closes the modal and confirms', function (): void {
    $component = Livewire::test('cookbook-edit-member')
        ->call('edit', 3)
        ->set('name', 'Sarah C. Chen')
        ->set('role', 'admin')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('modal:edit-member:close')
        ->assertDispatched('toast', type: 'success', message: 'Sarah C. Chen updated')
        ->assertSet('editingId', null);

    expect(collect($component->get('members'))->firstWhere('id', 3))
        ->toMatchArray(['name' => 'Sarah C. Chen', 'role' => 'admin']);
});

it('refuses an email used by someone else and an unknown role', function (): void {
    Livewire::test('cookbook-edit-member')
        ->call('edit', 3)
        ->set('email', 'marc@acme.dev')
        ->set('role', 'superuser')
        ->call('save')
        ->assertHasErrors(['email', 'role'])
        ->assertNotDispatched('modal:edit-member:close');
});

it('refuses to save without a row opened first', function (): void {
    Livewire::test('cookbook-edit-member')
        ->set('name', 'Nobody')
        ->call('save')
        ->assertForbidden();
});

it('keeps the edited row out of the browser reach', function (): void {
    expect(fn () => Livewire::test('cookbook-edit-member')->set('editingId', 1))
        ->toThrow(CannotUpdateLockedPropertyException::class);
});

// ---------------------------------------------------------------- delete, then undo

it('deletes after confirmation and offers undo', function (): void {
    Livewire::test('cookbook-delete-undo')
        ->call('confirmDelete', 3)
        ->assertDispatched('modal:delete-file:open')
        ->assertSee('Delete customers-export.csv?')
        ->call('delete')
        ->assertDispatched('modal:delete-file:close')
        ->assertDispatched('toast', fn (string $name, array $params): bool => $params['action']['event'] === 'cookbook-file-restore'
            && $params['action']['params'] === ['id' => 3])
        ->assertDontSee('customers-export.csv');
});

it('restores a deleted file from the undo event', function (): void {
    Livewire::test('cookbook-delete-undo')
        ->call('confirmDelete', 3)
        ->call('delete')
        ->dispatch('cookbook-file-restore', id: 3)
        ->assertSee('customers-export.csv')
        ->assertDispatched('toast', type: 'success', message: 'customers-export.csv restored');
});

it('refuses to restore a file that was never deleted', function (): void {
    Livewire::test('cookbook-delete-undo')
        ->dispatch('cookbook-file-restore', id: 1)
        ->assertNotFound();
});

// ---------------------------------------------------------------- country, then city

it('lists the cities of the chosen country and resets the city', function (): void {
    Livewire::test('cookbook-country-city')
        ->set('country', 'fr')
        ->set('city', 'lyon')
        ->set('country', 'jp')
        ->assertSet('city', '')
        ->assertSee('Tokyo')
        ->assertDontSee('Lyon');
});

it('refuses a city from another country', function (): void {
    Livewire::test('cookbook-country-city')
        ->set('country', 'jp')
        ->set('city', 'paris')
        ->call('save')
        ->assertHasErrors(['city' => 'in']);
});

it('saves a city that belongs to the country', function (): void {
    Livewire::test('cookbook-country-city')
        ->set('country', 'jp')
        ->set('city', 'kyoto')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('toast', type: 'success', message: 'Address saved');
});

// ---------------------------------------------------------------- assign with a search

it('searches people on the server, as text', function (): void {
    Livewire::test('cookbook-assign-search')
        ->set('query', 'eng')
        ->assertSee('Carlos Mendes')
        ->assertDontSee('Amara Diallo')
        ->set('query', '%')
        ->assertDontSee('Carlos Mendes');
});

it('names the people already assigned without listing them as results', function (): void {
    $html = Livewire::test('cookbook-assign-search')->html();

    expect($html)->toContain('data-listbox-known')
        ->and(substr_count($html, 'data-select-item="diane"'))->toBe(1);
});

it('refuses unknown or too many reviewers', function (array $reviewers, string $error): void {
    Livewire::test('cookbook-assign-search')
        ->set('reviewers', $reviewers)
        ->call('save')
        ->assertHasErrors($error);
})->with([
    'unknown' => [['diane', 'mallory'], 'reviewers.1'],
    'too many' => [['amara', 'brenda', 'carlos', 'diane', 'elias', 'fatou'], 'reviewers'],
    'none' => [[], 'reviewers'],
]);

it('assigns valid reviewers', function (): void {
    Livewire::test('cookbook-assign-search')
        ->set('reviewers', ['diane', 'joanna'])
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('toast', type: 'success', message: 'Reviewers assigned');
});
