@props(['class' => '', 'noMaxW' => false, 'nopadding' => false, 'as' => 'div'])

@php
    $tag = $as;
@endphp


<{{ $tag }}
    class="{{ $noMaxW ? '' : 'max-w-7xl' }} mx-auto w-full {{ $nopadding ? '' : 'px-4 sm:px-10 lg:px-5 xl:px-12' }} {{ $class }}">
    {{ $slot }}
</{{ $tag }}>