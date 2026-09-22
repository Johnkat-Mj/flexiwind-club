<ul
    {{ $attributes->class([
        'grid max-h-96 w-full grid-cols-[auto_1fr] flex-col',
        "gap-y-1 overflow-y-auto outline-hidden *:[[role='group']+[role=group]]:mt-4",
        "*:[[role='group']+[role=separator]]:mt-1",
    ]) }}>
{{ $slot }}
</ul>
