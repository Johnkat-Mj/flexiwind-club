@props(['title', 'description'])

<div class="w-full pt-10 border-b pb-4 border-border px-2 border-dashed">
    <h2 class="text-fg-title font-medium text-lg md:text-xl max-w-xl">
        {{ $title }}
    </h2>
    <p class="max-w-lg text-sm md:text-base text-fg-muted font-300 mt-1">
        {{ $description }}
    </p>
</div>
