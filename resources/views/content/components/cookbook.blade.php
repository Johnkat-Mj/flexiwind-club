<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug">
    <x-md.h2>Cookbook goals</x-md.h2>
    <x-md.paragraph>
        The cookbook is a place for practical UI recipes: small decisions, snippets, and examples that make Laravel
        interfaces faster to build and easier to maintain.
    </x-md.paragraph>
    <x-md.paragraph>
        Use it when you already know which component you need, but you want a clean pattern for combining it with forms,
        actions, validation, confirmations, and page workflows.
    </x-md.paragraph>

    <x-docs.links-grid :links="[
        [
            'href' => '/components/cookbook/modal-forms',
            'title' => 'Modal Forms',
            'description' => 'A practical modal form structure for create and edit flows.',
            'icon' => 'ph--browser',
        ],
        [
            'href' => '/components/cookbook/confirmation-dialogs',
            'title' => 'Confirmation Dialogs',
            'description' => 'A compact pattern for destructive or irreversible actions.',
            'icon' => 'ph--warning-circle',
        ],
        [
            'href' => '/components/cookbook/form-snippets',
            'title' => 'Form Snippets',
            'description' => 'Reusable form conventions for labels, help text, errors, and actions.',
            'icon' => 'ph--code-block',
        ],
    ]" />

    <x-md.h2>What belongs here</x-md.h2>
    <x-md.ul>
        <x-md.li>Good practices that are too practical for conceptual docs.</x-md.li>
        <x-md.li>Copyable snippets for common UI flows.</x-md.li>
        <x-md.li>Examples that combine multiple components into a real product interaction.</x-md.li>
        <x-md.li>AI-friendly prompts and notes that explain how a snippet should be adapted.</x-md.li>
    </x-md.ul>
</x-layouts.doc-page-wrapper>
