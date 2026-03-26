@props(['title', 'description'])

<section class="pt-8 w-full mx-auto lg:max-w-336 xl:max-w-352 px-2 sm:px-4 xl:px-8">
    <div class="border-x border-border-input/50 border-dashed w-full ">
        <x-ui.breadcrumb class="gap-2.5 whitespace-nowrap text-fg capitalize text-sm md:text-base">
            <x-ui.breadcrumb.item separator="ph--caret-right" href="/blocks" text="Blocks" />
            <x-ui.breadcrumb.item active :text="$title" />
        </x-ui.breadcrumb>
        <h2 class="text-fg-title mt-3 font-medium text-lg md:text-xl max-w-xl">
            {{ $title }}
        </h2>
        <p class="max-w-lg text-sm md:text-base text-fg-muted font-300 mt-1">
            {{ $description }}
        </p>
    </div>
</section>
