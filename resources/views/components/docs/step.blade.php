<li
    {{ $attributes->merge([
        'class' => 'step before:text-subtitle before:bg-subtle before:border before:border-border-strong after:bg-muted'
    ]) }}
>
    {{ $slot }}
</li>