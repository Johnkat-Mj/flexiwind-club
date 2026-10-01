@php
    use App\Support\SidebarPaginator;

    $path ??= '/' . ltrim(request()->path() ?: '', '/');
    $current ??= SidebarPaginator::getCurrent($path);
    $seo ??= SidebarPaginator::getSeo($current);
@endphp

<x-layouts.base
    body-class="bg-background  lg:bg-gray-50/50 dark:lg:bg-background  "
    :seo="$seo"
    :script-entries="['resources/js/app.js', 'resources/js/flexilla.js', 'resources/js/docs.js']"
>
    <x-organisms.doc-navbar />
    <div
        class="grid lg:grid-cols-[14rem_minmax(0,1fr)] xl:grid-cols-[14rem_minmax(0,1fr)] lg:pl-8 xl:pr-8 docs-container">
        <x-organisms.doc-sidebar :path="$path"/>
        <div class="grid relative">
            <span class="absolute left-0 w-4.5 sm:w-8 inset-y-0 linear-gradient-pattern border-x border-border bg-size-[9px_9px] sm:bg-size-[12px_12px] opacity-45 dark:opacity-65"></span>
            <x-molecules.top-docs-nav />
            {{ $slot }}
            <x-organisms.doc-footer />
        </div>
    </div>

    <x-blocks.modal-search />
</x-layouts.base>
