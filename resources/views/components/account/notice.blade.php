@props(['tone' => 'gray', 'icon' => null])

@php
    $icon ??= match ($tone) {
        'success' => 'ph--check-circle',
        'danger' => 'ph--warning-circle',
        default => 'ph--info',
    };
@endphp

<div role="{{ $tone === 'danger' ? 'alert' : 'status' }}" {{ $attributes->class([
    'flex items-start gap-3 rounded-xl border px-4 py-3 text-[13.5px]/5',
    match ($tone) {
        'success' => 'border-emerald-600/25 bg-emerald-600/6 text-emerald-800 dark:text-emerald-300',
        'danger' => 'border-red-600/25 bg-red-600/6 text-red-700 dark:text-red-300',
        default => 'border-border bg-surface text-foreground',
    },
]) }}>
    <span aria-hidden="true" class="iconify {{ $icon }} mt-0.5 shrink-0 text-base opacity-80"></span>
    <div class="min-w-0 flex-1">{{ $slot }}</div>
</div>
