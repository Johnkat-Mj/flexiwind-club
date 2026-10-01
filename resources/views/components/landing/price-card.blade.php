@props(['name', 'price', 'billing', 'tagline', 'features' => [], 'featured' => false])

<section @class([
    'relative flex flex-col rounded-[20px] border bg-background p-6 shadow-xs',
    'border-primary ring-3 ring-primary/12' => $featured,
    'border-border' => ! $featured,
])>
    <div class="flex items-center justify-between gap-2">
        <h3 class="text-[15px] font-semibold text-title-foreground">{{ $name }}</h3>
        @if ($featured)
            <span class="rounded-full bg-primary px-2 py-0.5 text-xs font-semibold text-primary-foreground">Most popular</span>
        @endif
    </div>
    <p class="mt-5 flex items-baseline gap-1.5">
        <span class="font-display text-4xl font-semibold tracking-[-0.03em] text-title-foreground">{{ $price }}</span>
        <span class="text-sm text-muted-foreground">{{ $billing }}</span>
    </p>
    <p class="mt-3 text-sm/relaxed text-muted-foreground">{{ $tagline }}</p>
    <ul class="mt-6 flex flex-1 flex-col gap-2.5 border-t border-border pt-5 text-sm">
        @foreach ($features as $feature)
            <li class="flex gap-2.5 text-foreground">
                <span aria-hidden="true" class="iconify ph--check mt-0.5 shrink-0 text-sm text-primary"></span>
                {{ $feature }}
            </li>
        @endforeach
    </ul>
    <div class="mt-7">{{ $slot }}</div>
</section>
