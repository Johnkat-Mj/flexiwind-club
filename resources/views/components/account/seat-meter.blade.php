{{-- Une barre par siège : pleine pour un membre, estompée pour une invitation en attente. --}}
@props(['used', 'members', 'seats'])

<span {{ $attributes->class('flex gap-1') }} role="meter" aria-valuemin="0" aria-valuemax="{{ $seats }}"
    aria-valuenow="{{ $used }}" aria-label="{{ $used }} of {{ $seats }} seats used">
    @for ($n = 0; $n < $seats; $n++)
        <span @class([
            'h-1.5 flex-1 rounded-full',
            'bg-primary' => $n < $members,
            'bg-primary/40' => $n >= $members && $n < $used,
            'bg-subtle' => $n >= $used,
        ])></span>
    @endfor
</span>
