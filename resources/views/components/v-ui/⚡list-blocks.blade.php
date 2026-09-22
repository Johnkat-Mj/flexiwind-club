<?php

use Livewire\Component;
use Illuminate\Support\Facades\Config;

new class extends Component {
    public $selectedGroup = 'all';
    public $selectedCategories = [];
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
            // Get all categories from all groups
            foreach ($blocksConfig as $groupKey => $groupData) {
                if (is_array($groupData)) {
                    foreach ($groupData as $categoryKey => $categoryData) {
                        $blockCount = isset($categoryData['blocks']) ? count($categoryData['blocks']) : 0;
                        $categories[] = [
                            'id' => $categoryKey,
                            'name' => $categoryData['title'] ?? ucfirst($categoryKey),
                            'illustrations' => $categoryData['illustrations'],
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
                        'illustrations' => $categoryData['illustrations'],
                        'count' => $blockCount,
                        'group' => $this->selectedGroup,
                    ];
                }
            }
        }

        return $categories;
    }

    public function selectGroup($groupId)
    {
        $this->selectedGroup = $groupId;
        $this->selectedCategories = []; // Reset categories when group changes
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }
    }

    public function resetToAll()
    {
        $this->selectedGroup = 'all';
    }
};
?>

<section class="relative">
    <div class="mx-auto w-full lg:max-w-336 xl:max-w-352 px-4 sm:px-6 xl:px-8">
        <ul class="pb-10 mt-14 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-3.5 gap-y-6">
            @forelse ($this->categories as $category)
                <li class="flex h-full">
                    <x-blocks.block-card :group="$category['group']" :count="$category['count']" :key="$category['id']" :title="$category['name']" :illustrations="$category['illustrations']" />
                </li>
            @empty
                <div class="col-span-full relative -mt-7">
                    <x-blocks.empty-state-site title="No blocks found for {{ $selectedGroup }}" description="Selected Groud doesn't have any block right now, stay tuned...">
                        <div class="mt-7 flex ">
                            <x-ui.button wire:click="resetToAll" variant="outline" size="sm">
                                Clear Filter
                            </x-ui.button>
                        </div>
                    </x-blocks.empty-state-site>
                </div>
            @endforelse
        </ul>
    </div>
</section>
