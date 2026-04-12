@props([
    'data' => [],
])

@if (count($data) === 1)
    <x-base.single-code-block :data="$data[0]" />
@else
    <div data-tab-fx-site x-f-tabs
        class="border border-gray-200 dark:border-gray-800/60 rounded-ui bg-gray-800 dark:bg-gray-900/50 grid mt-2.5 first:mt-0 text-gray-300">
        <div data-tab-list-wrapper
            class="grid overflow-hidden grid-cols-[1fr_2rem] gap-3 px-5 items-center h-10 pt-1 w-full">
            <ul role="tablist" data-tab-list class="flex items-center gap-x-3 flex-1 overflow-hidden overflow-x-auto">
                @foreach ($data as $item)
                    @php
                        $id = \Illuminate\Support\Str::slug($item['name']);
                        $icon = \App\Helpers\CodeIcon::get($item['lang']);
                    @endphp
                    <li role="presentation" class="d-flex-items-center pb-2">
                        <a data-tabs-trigger data-target="{{ $id }}" href="#{{ $id }}" role="tab"
                            aria-controls="{{ $id }}" aria-label="{{ $item['name'] }}"
                            class="flex h-full items-center rounded-md text-gray-400 fx-active:text-white hover:text-white ease-linear duration-200 focus:outline-none text-nowrap">
                            @if (\Illuminate\Support\Str::endsWith($icon, ['.png', '.svg', '.jpg']))
                                <img src="/icons/{{ $icon }}" alt="icon {{ $item['name'] }}" width="20"
                                    class="h-3 w-auto mr-2">
                            @else
                                <span class="flex mr-2 text-xs iconify {{ $icon }}"></span>
                            @endif
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="flex items-center">
                <x-atoms.btn-copy-code closest-el="[data-tab-fx-site]" :in-tabs="true" />
            </div>
        </div>

        <div data-panels-container
            class="relative group overflow-hidden max-h-140 xl:max-h-160 bg-[#07090] w-full grid">
            @foreach ($data as $item)
                @php
                    $id = \Illuminate\Support\Str::slug($item['name']);
                    $isFirst = $loop->first;
                @endphp
                <section data-tab-panel aria-labelledby="{{ $id }}" role="tabpanel" id="{{ $id }}"
                    tabindex="0" aria-hidden="{{ $isFirst ? 'false' : 'true' }}"
                    data-state="{{ $isFirst ? 'active' : 'inactive' }}"
                    class="hidden fx-active:flex active:outline-gray-800/50 focus:outline-gray-800/50 w-full">
                    <div data-code-component data-code-block data-code-box-collapsible
                        class="relative group overflow-hidden max-h-140 xl:max-h-160 w-full grid inner-radius">
                        <div class="w-full flex h-full overflow-auto *:py-0 [&_figure>pre]:py-4 [&_figure>pre]:min-w-full [&_figure>pre]:w-max [&_figure>pre]:px-3">
                            <x-base.render-block-code :code="$item['code']" :lang="$item['lang']" :lines="$item['lines'] ?? []" />
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </div>
@endif
