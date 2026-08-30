<?php

use Livewire\Component;

new class extends Component {
    public array $allBlocks = [];

    public function mount(): void
    {
        $this->allBlocks = config('blocks', []);
    }
}; ?>

<main class="overflow-hidden">
    <x-home.hero-section />
    <x-home.workflow-section />
    <x-home.included-section />
    <x-home.showcase-section />
    <x-home.offer-section />
    <x-home.faq-section />
    <x-home.final-cta />
</main>
