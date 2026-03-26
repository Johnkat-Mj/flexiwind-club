<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug" :links="[]">

    <x-md.image-block src="/cover-image.webp" alt="Flexiwind Club Cover Image" />

    <x-md.h2>Overview</x-md.h2>
    <x-md.paragraph>
        <strong>
            Flexiwind Club is the pro version of Flexiwind - bringing advanced components and powerful plugins to your Laravel applications.
        </strong>
    </x-md.paragraph>
    <x-md.paragraph>
        <strong>Flexiwind Club</strong> extends the open-source Flexiwind foundation with premium features including
        advanced form components like Select, Auto Complete, and Multi Select, as well as powerful plugins like Chart
        and Wysiwyg editor. Built with the same philosophy of <strong>code ownership</strong>, <strong>transparency</strong>, and
        <strong>flexibility</strong>.
    </x-md.paragraph>

    <x-md.paragraph>
        What you get with Flexiwind Club:
    </x-md.paragraph>
    <x-md.ul>
        <x-md.li>
            <strong>Advanced Components</strong> : Enhanced form controls with search, async loading, and multi-selection capabilities.
        </x-md.li>
        <x-md.li>
            <strong>Premium Plugins</strong> : Production-ready plugins for charts and rich text editing.
        </x-md.li>
        <x-md.li>
            <strong>Priority Support</strong> : Get help when you need it with priority access to our team.
        </x-md.li>
    </x-md.ul>

    <x-md.h2>Quick start</x-md.h2>

    <x-docs.links-grid :links="[
        [
            'href' => '/docs/installation',
            'title' => 'Installation',
            'description' => 'Add Flexiwind Club as a registry source in your project',
            'icon' => 'ph--compass',
        ],
        [
            'href' => '/components',
            'title' => 'Components',
            'description' => 'Browse our advanced components library',
            'icon' => 'ph--cube',
        ],
    ]" />
</x-layouts.doc-page-wrapper>
