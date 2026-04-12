<x-layouts.doc-page-wrapper :current="$current" :prev-slug="$prevSlug" :next-slug="$nextSlug" :links="[]">
    <x-md.h2>Prerequisites</x-md.h2>
    <x-md.paragraph>
        Before you begin, make sure you have:
    </x-md.paragraph>
    <x-md.ul>
        <x-md.li>A Laravel project with Flexiwind installed</x-md.li>
        <x-md.li>A Flexiwind Club license or subscription</x-md.li>
    </x-md.ul>

    <x-md.h2>Adding Flexiwind Club as Registry Source</x-md.h2>

    <x-docs.steps>
        <x-docs.step>
            <x-md.h3>Open your flexiwind.yaml configuration</x-md.h3>
            <x-md.paragraph>This file is located at the root of your Laravel project.</x-md.paragraph>
        </x-docs.step>

        <x-docs.step>
            <x-md.h3>Add the Flexiwind Club registry</x-md.h3>
            <x-md.paragraph>Add the following configuration to your <x-docs.inline-code text="flexiwind.yaml" /> file:</x-md.paragraph>
            
            <livewire:base.load-code name="club-pro-config" />
        </x-docs.step>

        <x-docs.step>
            <x-md.h3>Add your authentication token</x-md.h3>
            <x-md.paragraph>
                We recommand to add your token in .env, the token is required only when you want to add a component/block from flexiwind club. Create an env variable <x-docs.inline-code text="YOUR_FLEXIWIND_CLUB_TOKEN" /> (or name it as you want but make sure to match the one in your flexiwind.yaml) with your actual Flexiwind Club access token.
                You can find your token in your account dashboard after subscribing.
            </x-md.paragraph>
        </x-docs.step>

        <x-docs.step>
            <x-md.h3>Use the CLI to add components</x-md.h3>
            <x-md.paragraph>Now you can add Flexiwind Club components using the CLI:</x-md.paragraph>
            <livewire:base.terminal code="php artisan flexi:add @club/select" />
            <livewire:base.terminal code="php artisan flexi:add @club/sidebar05" />
        </x-docs.step>
    </x-docs.steps>

    <x-md.h2>Available Components</x-md.h2>
    <x-md.paragraph>Once configured, you have access to these advanced components and blocks:</x-md.paragraph>
    <x-docs.links-grid :links="[
         [
            'href' => '/blocks',
            'title' => 'Blocks',
            'description' => 'Multi-selection with tagging',
            'icon' => 'ph--cube',
        ],
         [
            'href' => '/templates',
            'title' => 'Templates',
            'description' => 'Browse ready to use templates',
            'icon' => 'ph--airplay',
        ],
        [
            'href' => '/components/select',
            'title' => 'Select',
            'description' => 'Enhanced select with search and grouping',
            'icon' => 'ph--list-dashes',
        ],
        [
            'href' => '/components/auto-complete',
            'title' => 'Auto Complete',
            'description' => 'Smart autocomplete with async loading',
            'icon' => 'ph--magnifying-glass',
        ],
        [
            'href' => '/components/multi-select',
            'title' => 'Multi Select',
            'description' => 'Multi-selection with tagging',
            'icon' => 'ph--checks',
        ]
    ]" />

    <x-md.h2>Available Plugins</x-md.h2>
    <x-md.paragraph>Flexiwind Club also includes these powerful plugins:</x-md.paragraph>
    <x-docs.links-grid :links="[
        [
            'href' => '/plugins/chart',
            'title' => 'Chart',
            'description' => 'Data visualization and charting',
            'icon' => 'ph--chart-bar',
        ],
        [
            'href' => '/plugins/wysiwyg',
            'title' => 'Wysiwyg',
            'description' => 'Rich text editor',
            'icon' => 'ph--text-t',
        ],
    ]" />
</x-layouts.doc-page-wrapper>
