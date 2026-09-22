@props([
    'name',
    'title' => null,
    'icon' => null,
    'shellStyle' => false,
])

@php
    try {
        $data = \App\Support\DocsCode::get($name) ?? [
            'code' => '',
            'lang' => '',
        ];
    } catch (\Exception) {
        $data = [
            'code' => '',
            'lang' => '',
        ];
    }
@endphp

<div data-code-block
    class="border border-gray-200 dark:border-gray-800/60 ui-card [--card-padding:--spacing(1)] [--card-radius:var(--radius-ui)] bg-gray-800 dark:bg-gray-900/50 grid mt-2.5 first:mt-0 text-gray-300">
    <x-docs.block-code :title="$title" :icon="$icon" :shell-style="$shellStyle">
        <x-docs.code-view-box :no-copy-button="true" class="bg-(--astro-code-color-background) inner-radius">
            <x-base.render-block-code :code="$data['code']" :lang="$data['lang']" :lines="$data['lines'] ?? []" />
        </x-docs.code-view-box>
    </x-docs.block-code>
</div>
