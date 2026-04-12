@props([
    'data' => [],
    'noTitle' => null,
])

<div data-code-block
    class="border border-gray-200 dark:border-gray-800/60 ui-card [--card-padding:--spacing(1)] [--card-radius:var(--radius-ui)] bg-gray-800 dark:bg-gray-900/50 grid mt-2.5 first:mt-0 text-gray-300">
    <x-docs.block-code :no-title="$noTitle" :title="$data['name']" :icon="$data['lang']">
        <x-docs.code-view-box :no-copy-button="true" class="bg-(--astro-code-color-background) inner-radius *:py-0 [&_figure>pre]:py-4 [&_figure>pre]:min-w-full [&_figure>pre]:w-max [&_figure>pre]:px-3">
            <x-base.render-block-code :code="$data['code']" :lang="$data['lang']" :lines="$data['lines'] ?? []" />
        </x-docs.code-view-box>
    </x-docs.block-code>
</div>
