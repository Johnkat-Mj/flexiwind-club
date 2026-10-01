@props([
    'type' => 'note', // "update" | "note" | "warning" | "important"
    'withoutIcon' => false,
])

@php
    // ui-subtle n'expose que primary, destructive, success et gray
    // (intents.css, matrice réduite). `info`, `warning` et `danger` n'existent
    // pas : les trois types concernés ne rendaient aucune couleur.
    $typeClasses = [
        'note' => 'ui-subtle-gray',
        'update' => 'ui-subtle-success',
        'warning' => 'ui-subtle-destructive',
        'important' => 'ui-subtle-primary',
    ];

    $icons = [
        'update' => 'ph--clock-clockwise',
        'note' => 'ph--lightbulb-filament',
        'warning' => 'ph--warning',
        'important' => 'ph--call-bell',
    ];

    $alertClass = $typeClasses[$type] ?? '';
    $iconClass = $icons[$type] ?? '';
@endphp

<div data-alert class="p-4 flex items-start gap-4 rounded-ui mt-4 first:mt-0 ui-subtle {{ $alertClass }}">
    @unless ($withoutIcon)
        <div class="pt-0.5">
            <span aria-hidden="true" class="flex iconify {{ $iconClass }} text-2xl"></span>
        </div>
    @endunless
    <div {{ $attributes->class(['flex-1']) }}>
        {{ $slot }}
    </div>
</div>
