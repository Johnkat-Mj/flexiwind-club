@props(['links' => [], 'current' => [], 'prevSlug' => '', 'nextSlug' => ''])

@php
    use App\Support\UrlHelper;

    $breadcrumbs = [
        'components' => ['href' => '/components', 'text' => 'Components'],
        'docs' => ['href' => '/docs', 'text' => 'Docs'],
    ];

    $repoContentLocation = config('base.editContentBaseUrl');
    $path = '/' . ltrim(request()->path() ?: '', '/');
    $filePath = ltrim(substr($path, strrpos($path, '/') + 1), '/') ?: trim($path, '/');
    $words = UrlHelper::splitSlug($filePath);
    $breadcrumbsMain = str_contains($path, '/components') ? $breadcrumbs['components'] : $breadcrumbs['docs'];
    $contentLocation = trim($path, '/');

    $slotHtml = (string) $slot;

@endphp

<main class="grid xl:grid-cols-[1fr_15rem]">
    <article data-pagefind-body class="px-4 sm:px-8 grid text-fg h-max relative">
        <div class="w-full xl:max-w-2xl mx-auto relative mb-13">
            <x-molecules.doc-page-header :title="$current['title']" :sub-title="$current['description']" :links="$links" :breadcrumbs-main="$breadcrumbsMain"
                :breadcrumbs-words="$words">
                <div class="flex items-center border border-border-input rounded-ui">
                    <x-ui.button size="sm" variant="none" data-copy-markdown>
                        <span aria-hidden="true" class="flex iconify ph--copy text-sm mr-1.5"></span>
                        <span>Copy as Markdown</span>
                    </x-ui.button>
                </div>
            </x-molecules.doc-page-header>
            <div data-doc-content class="py-10 w-full grid">
                {{ $slot }}
            </div>
            <div class="flex w-full hpx my-8 border-b border-border"></div>
            <x-molecules.doc-pagination :prev-slug="$prevSlug" :next-slug="$nextSlug" />
        </div>
    </article>
    <x-molecules.box-table-of-content :content-html="$slotHtml" :file-name="$contentLocation" :contrib-url="$repoContentLocation" />
</main>
