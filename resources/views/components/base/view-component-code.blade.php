@props([
    'filePath' => '',
    'isLazy' => true,
])

@php
    $code = '';

    if ($filePath !== '' && \Illuminate\Support\Facades\File::exists($filePath)) {
        $cacheKey = 'component_code_' . md5($filePath . \Illuminate\Support\Facades\File::lastModified($filePath));

        $code = cache()->remember($cacheKey, 3600, static fn (): string => \Illuminate\Support\Facades\File::get($filePath));
    }
@endphp

<x-docs.code-view-box>
    <x-base.render-block-code :code="$code" lang="blade" />
</x-docs.code-view-box>
