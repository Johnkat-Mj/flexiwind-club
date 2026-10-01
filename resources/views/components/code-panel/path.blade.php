@props(['target'])

@php
    $folder = str_contains($target, '/') ? dirname($target).'/' : '';
@endphp

<span {{ $attributes->class('truncate') }}><span class="text-code-muted">{{ $folder }}</span><span class="font-medium text-gray-50">{{ basename($target) }}</span></span>
