@php
    $confirmationExample = <<<'BLADE'
<x-ui.modal.trigger
    modal-id="delete-project-dialog"
    variant="outline"
    intent="danger"
>
    Delete project
</x-ui.modal.trigger>

<x-ui.modal id="delete-project-dialog" class="items-center justify-center">
    <x-ui.modal.content size="sm" :closable="false" class="p-(--gutter) text-center">
        <div class="mx-auto flex size-11 items-center justify-center rounded-full ui-soft ui-soft-danger">
            <span class="iconify ph--warning text-xl"></span>
        </div>

        <x-ui.modal.title class="mt-4">
            Delete this project?
        </x-ui.modal.title>

        <x-ui.modal.description class="mt-2">
            This action cannot be undone. All related project data will be removed.
        </x-ui.modal.description>

        <div class="mt-6 flex justify-center gap-3">
            <x-ui.modal.close variant="outline" intent="gray">
                Cancel
            </x-ui.modal.close>
            <x-ui.button intent="danger" wire:click="deleteProject">
                Delete project
            </x-ui.button>
        </div>
    </x-ui.modal.content>
</x-ui.modal>
BLADE;
@endphp

<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug">
    <x-md.h2>When to ask for confirmation</x-md.h2>
    <x-md.paragraph>
        Confirmation dialogs should be reserved for actions that are destructive, irreversible, expensive, or surprising.
        If the action can be undone easily, an undo toast is usually lighter than a dialog.
    </x-md.paragraph>

    <x-md.h2>Good confirmation copy</x-md.h2>
    <x-md.ul>
        <x-md.li>Name the object affected by the action.</x-md.li>
        <x-md.li>Explain the consequence in one short sentence.</x-md.li>
        <x-md.li>Make the destructive button specific, for example “Delete project”.</x-md.li>
        <x-md.li>Keep the cancel button visually calm and easy to find.</x-md.li>
    </x-md.ul>

    <x-md.h2>Demo</x-md.h2>
    <x-base.component-tab-preview-code component="components.examples.cookbook.confirmation-dialog" />

    <x-md.h2>Snippet</x-md.h2>
    <x-base.single-code-block :data="[
        'name' => 'confirmation-dialog.blade.php',
        'lang' => 'blade',
        'code' => $confirmationExample,
    ]" />
</x-layouts.doc-page-wrapper>
