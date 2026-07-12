@props(['allBlocks' => [], 'category', 'title' => ''])


<nav data-scrollable-container
    class="sticky top-0 lg:max-w-336 xl:max-w-352 px-2 sm:px-4 xl:px-8  mx-auto w-full h-12 flex gap-3
          border-b border-border bg-bg/60 backdrop-blur-sm z-40">
    <div class="flex border-x border-border">
        <x-ui.slideover.trigger size="none" variant="ghost" class="h-full px-3 text-sm" :radius="false"
            slideOverId="block-list">
            <x-ui.icon name="ph--funnel" />
            <span class="pl-2">Filter</span>
        </x-ui.slideover.trigger>
    </div>
    <div class="flex items-center flex-1 relative border-r border-border">
        <x-ui.breadcrumbs class="gap-2.5 whitespace-nowrap text-fg capitalize text-sm md:text-base">
            <x-ui.breadcrumbs.item separator="ph--circle-fill size-1!" href="/blocks" text="Blocks" />
            <x-ui.breadcrumbs.item active :text="$title" />
        </x-ui.breadcrumbs>
    </div>
</nav>


<x-ui.slideover :is-floated="false" position="left" id="block-list">
    <livewire:v-ui.blocks-filter />
</x-ui.slideover>
