@props(['initials' => '', 'color' => null])

<span {{ $attributes->class([
    'flex shrink-0 items-center justify-center rounded-full font-semibold text-white',
    'bg-linear-135 from-indigo-500 to-sky-500' => $color === null,
]) }} @if ($color) style="background: {{ $color }}" @endif>{{ $initials }}</span>
