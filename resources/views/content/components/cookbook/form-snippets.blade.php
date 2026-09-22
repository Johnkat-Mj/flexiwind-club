@php
    $fieldExample = <<<'BLADE'
<div class="grid gap-2">
    <div class="flex items-center justify-between gap-3">
        <x-ui.label for="team-name">Team name</x-ui.label>
        <span class="text-xs text-muted-foreground">Required</span>
    </div>

    <x-ui.input
        id="team-name"
        wire:model.blur="form.team_name"
        autocomplete="organization"
    />

    <p class="text-sm text-muted-foreground">
        Use the public name your teammates will recognize.
    </p>

    @error('form.team_name')
        <p class="text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
BLADE;

    $actionsExample = <<<'BLADE'
<div class="flex flex-col-reverse gap-3 border-t border-border pt-5 sm:flex-row sm:justify-end">
    <x-ui.button variant="outline" intent="gray" type="button">
        Cancel
    </x-ui.button>

    <x-ui.button type="submit" wire:loading.attr="disabled">
        <span wire:loading.remove>Save changes</span>
        <span wire:loading>Saving...</span>
    </x-ui.button>
</div>
BLADE;
@endphp

<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug">
    <x-md.h2>Field layout</x-md.h2>
    <x-md.paragraph>
        A good field block keeps label, input, help text, and validation error together. This makes the form easier to scan
        and easier for AI tools to modify without breaking the relationship between elements.
    </x-md.paragraph>

    <x-base.component-tab-preview-code component="components.examples.cookbook.form-field" />

    <x-base.single-code-block :data="[
        'name' => 'field-with-help-and-error.blade.php',
        'lang' => 'blade',
        'code' => $fieldExample,
    ]" />

    <x-md.h2>Action row</x-md.h2>
    <x-md.paragraph>
        Keep form actions predictable. On desktop, the primary action should usually sit on the right. On mobile, stacking
        the buttons keeps each tap target comfortable.
    </x-md.paragraph>

    <x-base.component-tab-preview-code component="components.examples.cookbook.form-actions" />

    <x-base.single-code-block :data="[
        'name' => 'form-actions.blade.php',
        'lang' => 'blade',
        'code' => $actionsExample,
    ]" />

    <x-md.h2>Small rules that help</x-md.h2>
    <x-md.ul>
        <x-md.li>Use <x-docs.inline-code>wire:model.blur</x-docs.inline-code> for fields that do not need instant updates.</x-md.li>
        <x-md.li>Keep help text neutral; reserve red text for validation errors.</x-md.li>
        <x-md.li>Disable submit buttons while saving to prevent duplicate actions.</x-md.li>
        <x-md.li>Use specific button labels like “Invite member” instead of generic labels like “Submit”.</x-md.li>
    </x-md.ul>
</x-layouts.doc-page-wrapper>
