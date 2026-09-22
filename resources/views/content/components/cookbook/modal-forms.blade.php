@php
    $modalFormExample = <<<'BLADE'
<x-ui.modal.trigger modal-id="create-project-modal">
    New project
</x-ui.modal.trigger>

<x-ui.modal id="create-project-modal">
    <x-ui.modal.content size="lg">
        <x-ui.modal.header
            title="Create project"
            description="Add the basic information now. You can refine settings later."
        />

        <form wire:submit="createProject">
            <x-ui.modal.body class="gap-5">
                <div class="grid gap-2">
                    <x-ui.label for="project-name">Project name</x-ui.label>
                    <x-ui.input id="project-name" wire:model.blur="form.name" autocomplete="off" />
                    @error('form.name')
                        <p class="text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="project-description">Description</x-ui.label>
                    <x-ui.textarea id="project-description" wire:model.blur="form.description" />
                </div>
            </x-ui.modal.body>

            <x-ui.modal.footer justify="end">
                <x-ui.modal.close variant="outline" intent="gray">
                    Cancel
                </x-ui.modal.close>
                <x-ui.button type="submit">
                    Create project
                </x-ui.button>
            </x-ui.modal.footer>
        </form>
    </x-ui.modal.content>
</x-ui.modal>
BLADE;
@endphp

<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug">
    <x-md.h2>When to use it</x-md.h2>
    <x-md.paragraph>
        Use a modal form when the action is short, contextual, and does not need a full page. Creating a project,
        inviting a teammate, editing a label, or updating a small setting are good examples.
    </x-md.paragraph>

    <x-md.h2>Basic form modal</x-md.h2>
    <x-md.paragraph>
        Use this version when the form submits through a regular POST request. It keeps the UI simple and works without
        any client-side state.
    </x-md.paragraph>
    <x-base.component-tab-preview-code component="components.examples.cookbook.modal-form-basic" />

    <x-md.h2>Livewire form modal</x-md.h2>
    <x-md.paragraph>
        Use this version when validation and saving happen inside a Livewire action. The modal should keep a clear loading
        state and should usually reset its form state after a successful save.
    </x-md.paragraph>
    <x-base.component-tab-preview-code component="components.examples.cookbook.modal-form-livewire" />

    <x-md.h2>Alpine controlled modal</x-md.h2>
    <x-md.paragraph>
        Use Alpine when the modal only needs local UI state. This is useful for small notes, filters, previews, or flows
        that do not need to round-trip to the server before closing.
    </x-md.paragraph>
    <x-base.component-tab-preview-code component="components.examples.cookbook.modal-form-alpine" />

    <x-md.h2>Recommended structure</x-md.h2>
    <x-md.ul>
        <x-md.li>Keep the trigger close to the list or card that owns the action.</x-md.li>
        <x-md.li>Use a clear title and one sentence of description in the modal header.</x-md.li>
        <x-md.li>Put validation messages directly under the related field.</x-md.li>
        <x-md.li>Keep the primary action on the right and the cancel action before it.</x-md.li>
    </x-md.ul>

    <x-md.h2>Snippet</x-md.h2>
    <x-base.single-code-block :data="[
        'name' => 'modal-form.blade.php',
        'lang' => 'blade',
        'code' => $modalFormExample,
    ]" />

    <x-md.h2>Livewire notes</x-md.h2>
    <x-md.paragraph>
        Prefer a dedicated form object or a grouped property like <x-docs.inline-code>form.name</x-docs.inline-code>.
        This keeps validation rules, reset logic, and submit behavior easier to reason about.
    </x-md.paragraph>
    <x-md.ul>
        <x-md.li>After saving successfully, dispatch a browser event or call your modal close helper, then reset the form.</x-md.li>
        <x-md.li>Use <x-docs.inline-code>wire:loading.attr="disabled"</x-docs.inline-code> on cancel and submit buttons.</x-md.li>
        <x-md.li>Use <x-docs.inline-code>wire:model.blur</x-docs.inline-code> unless the field needs instant feedback.</x-md.li>
    </x-md.ul>
</x-layouts.doc-page-wrapper>
