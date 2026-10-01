@props(['as' => 'div', 'noPadding' => false])

<{{ $as }}
    {{ $attributes->class(['relative mx-auto w-full max-w-300 ', 'px-4 sm:px-6 lg:px-10 xl:px-12' => !$noPadding]) }}>
    {{ $slot }}
    </{{ $as }}>
