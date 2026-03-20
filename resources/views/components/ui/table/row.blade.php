@props(['class' => '', 'noDivider' => true, 'hoverable' => false, 'striped' => false])


<tr
    {{ $attributes->class([
        'text-sm',
        'hover:bg-bg-muted/60 transition-colors ease-linear' => $hoverable,
        'odd:bg-bg even:bg-bg-muted/60' => $striped,
        'divide-y divide-border-strong/60' => !$noDivider,
        $class
    ]) }}>
    {{ $slot }}
</tr>
