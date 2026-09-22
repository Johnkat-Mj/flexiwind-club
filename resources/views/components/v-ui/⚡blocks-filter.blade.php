<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Config;

new class extends Component {
    public $selectedGroup = 'all';

    #[Url(as: 'q', history: false)]
    public $search = '';

    public $groups = [
        [
            'id' => 'all',
            'text' => 'All',
            'icon' => 'ph--squares-four-duotone',
        ],
        [
            'id' => 'application',
            'text' => 'Application',
            'icon' => 'ph--desktop-duotone',
        ],
        [
            'id' => 'marketing',
            'text' => 'Marketing',
            'icon' => 'ph--megaphone-duotone',
        ],
    ];

    public function getCategoriesProperty()
    {
        $blocksConfig = Config::get('blocks');
        $categories = [];

        if ($this->selectedGroup === 'all') {
            foreach ($blocksConfig as $groupKey => $groupData) {
                if (is_array($groupData)) {
                    foreach ($groupData as $categoryKey => $categoryData) {
                        $blockCount = isset($categoryData['blocks']) ? count($categoryData['blocks']) : 0;
                        $categories[] = [
                            'id' => $categoryKey,
                            'name' => $categoryData['title'] ?? ucfirst($categoryKey),
                            'illustrations' => $categoryData['illustrations'] ?? [],
                            'count' => $blockCount,
                            'group' => $groupKey,
                        ];
                    }
                }
            }
        } else {
            if (isset($blocksConfig[$this->selectedGroup]) && is_array($blocksConfig[$this->selectedGroup])) {
                foreach ($blocksConfig[$this->selectedGroup] as $categoryKey => $categoryData) {
                    $blockCount = isset($categoryData['blocks']) ? count($categoryData['blocks']) : 0;
                    $categories[] = [
                        'id' => $categoryKey,
                        'name' => $categoryData['title'] ?? ucfirst($categoryKey),
                        'illustrations' => $categoryData['illustrations'] ?? [],
                        'count' => $blockCount,
                        'group' => $this->selectedGroup,
                    ];
                }
            }
        }

        if ($this->search) {
            $categories = array_filter($categories, function ($cat) {
                return str_contains(strtolower($cat['name']), strtolower($this->search));
            });
        }

        return $categories;
    }

    public function selectGroup($groupId)
    {
        $this->selectedGroup = $groupId;
    }
};
?>
<x-ui.slideover.content class="border-r">
    <x-ui.slideover.header class="border-b border-border flex-col">
        <x-ui.slideover.title>Filter blocks</x-ui.slideover.title>
        <x-ui.input.group>
            <x-ui.input.leading absolute>
                <x-ui.icon name="ph--magnifying-glass" />
            </x-ui.input.leading>
            <x-ui.input variant="unstyled" placeholder="Start typing..." class="px-4 ps-9"
                x-data="{ localSearch: $wire.search }"
                x-model="localSearch"
                x-on:input.debounce.500ms="$wire.set('search', localSearch)" />
            <x-ui.input.trailing clickable>
                <x-ui.button variant="ghost" size="sm" icon-only
                    x-on:click="localSearch = ''; $wire.set('search', '')"
                    x-show="localSearch"
                    class="cursor-pointer">
                    <x-ui.icon name="ph--x" />
                </x-ui.button>
            </x-ui.input.trailing>
        </x-ui.input.group>
    </x-ui.slideover.header>

    <x-ui.slideover.body>
        <div class="mb-4">
            <span class="text-title-foreground  font-medium text-sm mb-3 block">
                Groups
            </span>
            <div class="flex flex-wrap gap-2">
                @foreach ($groups as $group)
                    <button wire:click="selectGroup('{{ $group['id'] }}')"
                        wire:key="group-{{ $group['id'] }}-{{ $selectedGroup }}-{{ $search }}"
                        data-state="{{ $selectedGroup === $group['id'] ? 'active' : 'inactive' }}"
                        class="h-7 text-sm px-2 flex items-center rounded-ui transition-colors duration-200 ring ring-border-strong/60
                    fx-active:bg-muted/50 fx-active:border-border-strong/70 fx-active:text-title-foreground  fx-active:shadow-md fx-active:shadow-black/5
                    text-muted-foreground hover:bg-muted/70 hover:text-subtitle
                    ">
                        <span class="iconify size-3 {{ $group['icon'] }} mr-1.5"></span>
                        <span class="text-sm font-medium">{{ $group['text'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        @php
            $groupNames = collect($groups)->keyBy('id')->map(fn($g) => $g['text']);
            $groupedCategories = [];
            foreach ($this->categories as $category) {
                $groupedCategories[$category['group']][] = $category;
            }
        @endphp

        <div class="flex flex-col gap-5">
            @forelse ($groupedCategories as $groupKey => $categoriesList)
                @php
                    $groupId = $selectedGroup === 'all' ? $groupKey : $selectedGroup;
                    $configGroup = Config::get("blocks.{$groupKey}");
                    $totalBlocks = collect($configGroup)->sum(fn($cat) => count($cat['blocks'] ?? []));
                @endphp
                <div class="flex flex-col">
                    <x-ui.collapse.trigger :target="$groupKey" class="flex items-center gap-2 justify-between text-title-foreground ">
                        <span class="font-medium text-sm flex-1 text-left">
                            {{ $groupNames[$groupKey] ?? ucfirst($groupKey) }}
                        </span>
                        <span class="text-xs text-foreground bg-surface ring ring-border px-2.5 py-px rounded">
                            {{ $totalBlocks }}
                        </span>
                    </x-ui.collapse.trigger>
                    <x-ui.collapse data-state="open" :id="$groupKey" class="mt-3 grid grid-cols-2 gap-x-2.5 gap-y-4">
                        @foreach ($categoriesList as $category)
                            <a href="{{ route('blocks.show', [$category['group'], $category['id']]) }}" wire:navigate
                                aria-label="Link to blocks : {{ $category['name'] }}"
                                class="hover:bg-surface p-px rounded-ui group ease-linear duration-200">
                                <div
                                    class="aspect-standard-tv bg-muted/30 rounded-ui pointer-events-none relative overflow-hidden">
                                    @if (isset($category['illustrations']['light']))
                                        <img src="{{ $category['illustrations']['light'] }}"
                                            alt="Illustration light {{ $category['name'] }}" width="1455"
                                            height="1091" class="size-full object-cover dark:hidden">
                                    @endif
                                    @if (isset($category['illustrations']['dark']))
                                        <img src="{{ $category['illustrations']['dark'] }}"
                                            alt="Illustration dark {{ $category['name'] }}" width="1455"
                                            height="1091" class="size-full object-cover not-dark:hidden">
                                    @endif
                                    <span
                                        class="text-xs absolute top-2 right-1.5 px-2 py-0.5 rounded bg-muted/50 text-foreground backdrop-blur-sm ring ring-border">
                                        {{ $category['count'] }} blocks
                                    </span>
                                </div>
                                <div class="mt-0.5 pb-2 px-1">
                                    <h3 class="font-medium text-title-foreground  text-sm">
                                        {{ $category['name'] }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </x-ui.collapse>
                </div>
            @empty
                <p class="text-muted-foreground text-sm px-3">No categories available.</p>
            @endforelse
        </div>
    </x-ui.slideover.body>

</x-ui.slideover.content>
