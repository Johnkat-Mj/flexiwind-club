@props(['noDivider' => false, 'striped' => false, 'class' => ''])



<tbody
    {{ $attributes->class([
        'text-sm',
        'divide-y divide-border-strong/60' => !$noDivider,
        '*:odd:bg-bg *:even:bg-bg-muted/70' => $striped,
        $class,
    ]) }}>
    {{ $slot }}
</tbody>
