<?php

use App\Flexiwind\OptionList;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Livewire\Livewire;

enum ListboxTestPlan: string
{
    case Starter = 'starter';
    case Team = 'team';

    public function label(): string
    {
        return ucfirst($this->value).' plan';
    }
}

/** La config passée à fwListbox() : @js l'écrit sous la forme JSON.parse('…'). */
function listboxConfig(string $html): array
{
    preg_match("/x-data=\"fwListbox\\(JSON\\.parse\\('(.*?)'\\)\\)\"/s", $html, $match);

    return json_decode(json_decode('"'.$match[1].'"'), true);
}

// ---------------------------------------------------------------- options

it('reads a list of values as values and labels', function (): void {
    expect(OptionList::normalize(['Paris', 'Lyon']))->sequence(
        fn ($option) => $option->toMatchArray(['value' => 'Paris', 'label' => 'Paris']),
        fn ($option) => $option->toMatchArray(['value' => 'Lyon', 'label' => 'Lyon']),
    );
});

it('reads an associative array as value => label', function (): void {
    expect(OptionList::normalize(['fr' => 'France', 'cd' => 'DR Congo'])[1])
        ->toMatchArray(['value' => 'cd', 'label' => 'DR Congo']);
});

it('reads rows, objects and collections with custom keys', function (): void {
    $rows = collect([
        ['id' => 7, 'name' => 'Alice', 'email' => 'alice@example.com', 'team' => 'Design', 'away' => true],
        (object) ['id' => 8, 'name' => 'Marc'],
    ]);

    $options = OptionList::normalize($rows, ['value' => 'id', 'label' => 'name', 'description' => 'email', 'group' => 'team', 'disabled' => 'away']);

    expect($options[0])->toMatchArray(['value' => '7', 'label' => 'Alice', 'description' => 'alice@example.com', 'group' => 'Design', 'disabled' => true])
        ->and($options[1])->toMatchArray(['value' => '8', 'label' => 'Marc', 'description' => null, 'disabled' => false]);
});

it('reads enum cases, with their label when they have one', function (): void {
    expect(OptionList::normalize(ListboxTestPlan::cases())[1])->toMatchArray(['value' => 'team', 'label' => 'Team plan']);
});

it('groups options in order of appearance', function (): void {
    $groups = OptionList::groups(OptionList::normalize([
        ['value' => 'a', 'label' => 'A'],
        ['value' => 'b', 'label' => 'B', 'group' => 'Two'],
        ['value' => 'c', 'label' => 'C', 'group' => 'One'],
    ]));

    expect(array_column($groups, 'label'))->toBe([null, 'Two', 'One']);
});

it('turns a starting value into strings and drops empty ones', function (): void {
    expect(OptionList::selected([1, '', null, ListboxTestPlan::Team, ['nested']]))->toBe(['1', 'team'])
        ->and(OptionList::selected('fr'))->toBe(['fr'])
        ->and(OptionList::selected(null))->toBe([]);
});

// ---------------------------------------------------------------- listbox

it('renders a trigger, a panel and dropdown items', function (): void {
    $html = Blade::render('<x-ui.listbox name="framework" label="Framework" :options="[\'laravel\' => \'Laravel\']" />');

    expect($html)
        ->toContain('data-select-trigger')
        ->toContain('data-select-content')
        ->toContain('data-select-item="laravel"')
        ->toContain('data-label="Laravel"')
        ->toContain('dropdown-item-base')
        ->toContain('ph--check-bold')
        ->toContain('data-fx-teleport-root')
        ->toContain('wire:ignore')
        ->not->toContain('data-multiple');
});

it('escapes labels and values that come from the data', function (): void {
    $html = Blade::render('<x-ui.listbox name="x" :options="$options" />', [
        'options' => [['value' => '"><script>alert(1)</script>', 'label' => '<img src=x onerror=alert(1)>']],
    ]);

    expect($html)
        ->not->toContain('<script>alert(1)</script>')
        ->not->toContain('<img src=x')
        ->toContain('&lt;img src=x onerror=alert(1)&gt;');
});

it('passes the starting value to Alpine as JSON', function (): void {
    $html = Blade::render('<x-ui.listbox name="reviewers" multiple :value="[\'a\', \'b\']" :options="[\'a\' => \'A\', \'b\' => \'B\']" />');

    $config = listboxConfig($html);

    expect($config)->toMatchArray(['kind' => 'select', 'multiple' => true, 'value' => ['a', 'b'], 'name' => 'reviewers']);
});

it('renders groups, icons, avatars and descriptions', function (): void {
    $html = Blade::render('<x-ui.listbox name="p" :options="$options" option-group="team" />', [
        'options' => [
            ['value' => 'a', 'label' => 'Alice', 'team' => 'Design', 'avatar' => 'https://example.com/a.png', 'description' => 'Lead'],
            ['value' => 'b', 'label' => 'Build', 'icon' => 'ph--hammer'],
        ],
    ]);

    expect($html)
        ->toContain('role="group"')
        ->toContain('>Design</div>')
        ->toContain('data-slot="avatar"')
        ->toContain('data-avatar="https://example.com/a.png"')
        ->toContain('data-description="Lead"')
        ->toContain('ph--hammer');
});

it('adds a search field only when searchable', function (): void {
    expect(Blade::render('<x-ui.listbox name="a" searchable :options="[\'x\']" />'))->toContain('data-select-input')
        ->and(Blade::render('<x-ui.listbox name="a" :options="[\'x\']" />'))->not->toContain('data-select-input');
});

it('gives two fields with the same name different ids', function (): void {
    $html = Blade::render('<x-ui.listbox name="reviewers" label="One" :options="[\'a\']" /><x-ui.listbox name="reviewers" label="Two" :options="[\'a\']" />');

    preg_match_all('/data-listbox-id="([^"]+)"/', $html, $ids);

    expect(array_values(array_unique($ids[1])))->toHaveCount(2);
});

it('turns invalid on when the field has a validation error', function (): void {
    View::share('errors', (new ViewErrorBag)->put('default', new MessageBag(['plan' => ['Choose a plan.']])));

    $html = Blade::render('<x-ui.listbox name="plan" :options="[\'a\']" />');

    expect($html)->toContain('data-invalid')->toContain('aria-invalid="true"');
});

it('sends aria attributes to the trigger', function (): void {
    $html = Blade::render('<x-ui.listbox name="plan" aria-describedby="plan-error" :options="[\'a\']" />');

    expect($html)->toMatch('/<button[^>]*data-select-trigger[^>]*aria-describedby="plan-error"|<button[^>]*aria-describedby="plan-error"[^>]*data-select-trigger/s');
});

// ---------------------------------------------------------------- composition

it('leaves the whole composition to the page when it brings its own panel', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.listbox name="owner">
            <x-ui.listbox.trigger class="custom-trigger">
                <x-ui.listbox.value placeholder="Choose an owner">
                    <span data-bind="initials"></span> <span data-bind="label"></span>
                </x-ui.listbox.value>
            </x-ui.listbox.trigger>
            <x-ui.listbox.content>
                <x-ui.listbox.search placeholder="Search people" />
                <x-ui.listbox.list>
                    <x-ui.listbox.item value="alice" data-initials="AJ">
                        <x-ui.listbox.avatar>AJ</x-ui.listbox.avatar>
                        <x-ui.listbox.label>Alice Johnson</x-ui.listbox.label>
                        <x-ui.listbox.description>alice@example.com</x-ui.listbox.description>
                    </x-ui.listbox.item>
                </x-ui.listbox.list>
                <x-ui.listbox.empty>Nobody named “<x-ui.listbox.query />”</x-ui.listbox.empty>
            </x-ui.listbox.content>
        </x-ui.listbox>
        BLADE);

    expect(substr_count($html, 'data-select-trigger'))->toBe(1)
        ->and(substr_count($html, 'data-select-content'))->toBe(1)
        ->and($html)
        ->toContain('custom-trigger')
        ->toContain('data-bind="initials"')
        ->toContain('<template data-selected-model>')
        ->toContain('Choose an owner')
        ->toContain('placeholder="Search people"')
        ->toContain('data-initials="AJ"')
        ->toContain('data-slot="avatar"')
        ->toContain('data-select-empty-query');
});

it('keys the parts that Flexilla changes, so Livewire keeps them between renders', function (): void {
    $html = Blade::render('<x-ui.listbox name="a" searchable :options="[\'x\']" /><x-ui.autocomplete name="b" :options="[\'y\']" />');

    expect($html)
        ->toContain('wire:key="listbox-trigger"')
        ->toContain('wire:key="listbox-content"')
        ->toContain('wire:key="listbox-list"')
        ->toContain('wire:key="listbox-search"')
        ->toContain('wire:key="autocomplete-input"');
});

it('reads the label part for search and values, not the description', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.listbox.item value="a">
            <x-ui.listbox.label>Alice Johnson</x-ui.listbox.label>
            <x-ui.listbox.description>alice@example.com</x-ui.listbox.description>
        </x-ui.listbox.item>
        BLADE);

    expect($html)->toContain('data-label="Alice Johnson"');
});

it('turns plain text into the label of an item', function (): void {
    expect(Blade::render('<x-ui.listbox.item value="a">Astro</x-ui.listbox.item>'))
        ->toContain('data-slot="label"')
        ->toContain('data-label="Astro"');
});

it('places free markup in the label column', function (): void {
    expect(Blade::render('<x-ui.listbox.item value="a"><strong>Astro</strong> <em>framework</em></x-ui.listbox.item>'))
        ->toContain('<span class="col-start-2 min-w-0"><strong>Astro</strong>')
        ->toContain('data-label="Astro framework"');
});

it('lets the label prop win over the item content', function (): void {
    expect(Blade::render('<x-ui.listbox.item value="a" label="Short">A very long label</x-ui.listbox.item>'))
        ->toContain('data-label="Short"');
});

it('offers a value mode for each way of showing a selection', function (string $mode): void {
    expect(Blade::render("<x-ui.listbox.value mode=\"{$mode}\" />"))->toContain("data-mode=\"{$mode}\"");
})->with(['single', 'chips', 'list', 'count', 'compact']);

it('composes an autocomplete with the listbox parts', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.autocomplete name="team" multiple>
            <x-ui.autocomplete.input placeholder="Type a name" />
            <x-ui.listbox.value mode="chips"><span data-bind="label"></span></x-ui.listbox.value>
            <x-ui.listbox.content>
                <x-ui.listbox.list>
                    <x-ui.listbox.item value="alice">Alice</x-ui.listbox.item>
                </x-ui.listbox.list>
            </x-ui.listbox.content>
        </x-ui.autocomplete>
        BLADE);

    expect(substr_count($html, 'data-select-input'))->toBe(1)
        ->and(substr_count($html, 'data-select-content'))->toBe(1)
        ->and($html)->toContain('placeholder="Type a name"')->toContain('data-select-item="alice"');
});

// ---------------------------------------------------------------- autocomplete

it('renders the input as the trigger with a placeholder option', function (): void {
    $html = Blade::render('<x-ui.autocomplete name="city" :options="[\'Paris\', \'Lyon\']" />');

    expect($html)
        ->toContain('data-select-input')
        ->toContain('data-select-item="__fw-none"')
        ->toContain('data-select-item="Paris"')
        ->not->toContain('data-autocomplete-source');
});

it('mirrors server results in a source block for Livewire searches', function (): void {
    $html = Blade::render('<x-ui.autocomplete wire:model="customer" search="query" :options="[\'Ada\']" />');

    $config = listboxConfig($html);

    expect($html)->toContain('data-autocomplete-source')->toContain('wire:target="query"')
        ->and($config)->toMatchArray(['kind' => 'autocomplete', 'search' => 'query', 'minChars' => 1, 'debounce' => 300]);
});

it('keeps the autocomplete id stable while search results change', function (): void {
    $render = fn (array $options): string => Blade::render('<x-ui.autocomplete wire:model="c" search="query" :options="$options" />', ['options' => $options]);

    preg_match('/data-listbox-id="([^"]+)"/', $render(['Ada']), $first);
    preg_match('/data-listbox-id="([^"]+)"/', $render(['Bob', 'Carla']), $second);

    expect($first[1])->toBe($second[1]);
});

it('renders the autocomplete examples', function (string $example): void {
    expect(Blade::render("<x-examples.autocomplete.{$example} />"))->toContain('data-slot="autocomplete"');
})->with(['demo', 'multiple', 'list', 'states', 'compose-owner', 'compose-team']);

it('renders the listbox examples', function (string $example): void {
    expect(Blade::render("<x-examples.listbox.{$example} />"))->toContain('data-slot="listbox"');
})->with(['demo', 'searchable', 'groups', 'multiple', 'summaries', 'states', 'compose-owner', 'compose-reviewers', 'compose-status', 'compose-summary']);

// ---------------------------------------------------------------- toaster

it('writes the toaster settings as data attributes', function (): void {
    $html = Blade::render('<x-ui.toaster position="top-center" close-button rich-colors duration="5000" />');

    expect($html)
        ->toContain('data-fw-toaster')
        ->toContain('data-position="top-center"')
        ->toContain('data-close-button')
        ->toContain('data-rich-colors')
        ->toContain('data-duration="5000"');
});

it('falls back to bottom-right for an unknown position', function (): void {
    expect(Blade::render('<x-ui.toaster position="middle" />'))->toContain('data-position="bottom-right"');
});

it('writes a flashed toast as JSON that cannot close its script tag', function (): void {
    session()->flash('toast', ['type' => 'success', 'message' => '</script><script>alert(1)</script>']);

    $html = Blade::render('<x-ui.toaster />');

    expect($html)
        ->toContain('data-fw-toast')
        ->not->toContain('</script><script>alert(1)')
        ->toContain(trim(json_encode('<', JSON_HEX_TAG), '"'));
});

// ---------------------------------------------------------------- Livewire demos

it('sends the listbox demo a real array', function (): void {
    Livewire::test('listbox-demo')
        ->assertSet('reviewers', ['alice', 'marc'])
        ->set('reviewers', ['sarah'])
        ->assertHasNoErrors()
        ->assertSee('[&quot;sarah&quot;]', false);
});

it('refuses a reviewer that is not in the list', function (): void {
    Livewire::test('listbox-demo')
        ->set('reviewers', ['mallory'])
        ->assertHasErrors('reviewers.0');
});

it('filters customers on the server from the typed text', function (): void {
    Livewire::test('autocomplete-demo')
        ->assertDontSee('Joanna Lee')
        ->set('query', 'joan')
        ->assertSee('Joanna Lee')
        ->assertDontSee('Amara Diallo');
});

it('treats the typed text as text, not as a pattern', function (): void {
    Livewire::test('autocomplete-demo')
        ->set('query', '%')
        ->assertDontSee('Joanna Lee')
        ->set('query', str_repeat('a', 500))
        ->assertSet('query', str_repeat('a', 80));
});

it('dispatches toasts from the demo', function (): void {
    Livewire::test('toast-demo')
        ->call('save')
        ->assertDispatched('toast', type: 'success', message: 'Profile saved')
        ->call('archive')
        ->assertDispatched('toast', message: 'Project archived');
});
