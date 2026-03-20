<?php

use Livewire\Component;

new class extends Component {
    public $allBlocks;

    public function mount()
    {
        $blocks = config('blocks');
        $this->allBlocks = $blocks;
    }
    //
}; ?>
<main class="">
    
</main>
