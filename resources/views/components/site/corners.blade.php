{{-- Coins de recadrage : l'élément parent doit être positionné. --}}
@props(['inset' => 'inset-6', 'size' => 'size-4.5'])

<span aria-hidden="true" class="pointer-events-none absolute {{ $inset }}">
    <span class="absolute top-0 left-0 {{ $size }} border-t-[1.5px] border-l-[1.5px] border-border-strong"></span>
    <span class="absolute top-0 right-0 {{ $size }} border-t-[1.5px] border-r-[1.5px] border-border-strong"></span>
    <span class="absolute bottom-0 left-0 {{ $size }} border-b-[1.5px] border-l-[1.5px] border-border-strong"></span>
    <span class="absolute right-0 bottom-0 {{ $size }} border-r-[1.5px] border-b-[1.5px] border-border-strong"></span>
</span>
