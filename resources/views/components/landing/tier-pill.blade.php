@props(['free' => true])

<span {{ $attributes->class([
    'shrink-0 rounded-full px-2.25 py-0.5 text-xs font-semibold',
    'bg-subtle text-foreground' => $free,
    'bg-gray-900 text-white dark:bg-white dark:text-gray-950' => ! $free,
]) }}>{{ $free ? 'Free' : 'Paid' }}</span>
