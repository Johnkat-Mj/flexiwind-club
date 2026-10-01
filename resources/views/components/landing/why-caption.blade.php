@props(['kicker', 'title'])

<div class="flex flex-col gap-1.5 px-6.5 pt-5 pb-6">
    <span class="font-mono text-[11.5px] font-medium tracking-[.06em] text-primary uppercase">{{ $kicker }}</span>
    <span class="font-display text-xl/6.5 font-semibold tracking-[-0.02em] text-title-foreground">{{ $title }}</span>
    <span class="text-[14.5px]/[1.6] text-pretty text-muted-foreground">{{ $slot }}</span>
</div>
