@props(['dependencies' => []])

@foreach ($dependencies as $dependency)
    <span class="flex h-5 items-center rounded-[5px] bg-white/6 px-1.75 font-mono text-[11px] text-gray-300">{{ $dependency }}</span>
@endforeach
