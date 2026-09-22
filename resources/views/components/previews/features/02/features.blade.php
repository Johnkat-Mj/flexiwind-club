<section class="py-20 lg:py-32">
    <div class="px-5 sm:px-10 md:px-12 lg:px-5 lg:max-w-7xl mx-auto w-full">
        <span
            class="flex mx-auto w-max pl-5 relative text-primary text-center before:absolute before:w-4 before:h-0.5 before:rounded-md before:left-0 before:top-1/2 before:flex before:bg-primary">
            Features
        </span>
        <h1
            class="mt-5 text-3xl md:text-4xl xl:text-5xl mx-auto text-center md:max-w-2xl text-title-foreground  font-semibold leading-tight">
            Keep your business on growing
        </h1>
        <x-ui.text class="max-w-lg mt-6 text-center mx-auto">
            Manage leads, automate workflows, and close more deals faster —
            everything you need to grow your business in one place.
        </x-ui.text>

        @php
            $features = [
                [
                    'icon' => 'ph--users',
                    'title' => 'Lead Management',
                    'description' =>
                        'Capture, track, and nurture leads from multiple channels. Organize prospects with smart tagging and automated follow-up sequences.',
                ],
                [
                    'icon' => 'ph--gear',
                    'title' => 'Workflow Automation',
                    'description' =>
                        'Streamline repetitive tasks with powerful automation. Set up triggers, actions, and conditions to save time and reduce errors.',
                ],
                [
                    'icon' => 'ph--chart-line',
                    'title' => 'Analytics & Reporting',
                    'description' =>
                        'Get deep insights into your business performance with real-time dashboards and customizable reports that drive data-driven decisions.',
                ],
                [
                    'icon' => 'ph--chat-circle',
                    'title' => 'Team Collaboration',
                    'description' =>
                        'Keep your team aligned with shared workspaces, real-time messaging, and collaborative project management tools.',
                ],
                [
                    'icon' => 'ph--plugs',
                    'title' => 'API Integration',
                    'description' =>
                        'Connect with your favorite tools seamlessly. Our robust API and pre-built integrations work with 500+ popular business apps.',
                ],
                [
                    'icon' => 'ph--shield-check',
                    'title' => 'Security & Compliance',
                    'description' =>
                        'Enterprise-grade security with SOC 2 compliance, end-to-end encryption, and advanced access controls to protect your data.',
                ],
            ];
        @endphp
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-y-12 sm:gap-y-16 sm:gap-x-12 mt-16">
            @foreach ($features as $feature)
                <x-previews.features.02.feature-card icon="{{ $feature['icon'] }}" title="{{ $feature['title'] }}"
                    description="{{ $feature['description'] }}" />
            @endforeach
        </div>
    </div>
</section>
