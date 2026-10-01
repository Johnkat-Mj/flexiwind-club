@props(['n', 'title', 'text' => ''])

<li class="flex gap-3.5 border-t border-border/60 py-3.5 first:border-t-0">
    <span class="flex size-6.5 shrink-0 items-center justify-center rounded-full border border-border text-[12.5px] font-semibold text-title-foreground">{{ $n }}</span>
    <div class="min-w-0 flex-1">
        <p class="text-[14.5px] font-semibold text-title-foreground">{{ $title }}</p>
        @if ($text)
            <p class="mt-0.5 text-[13.5px] text-muted-foreground">{{ $text }}</p>
        @endif
        {{ $slot }}
    </div>
</li>
