<?php

namespace App\Livewire;

use App\Support\DocsLayoutData;
use App\Support\SidebarPaginator;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ComponentPage extends Component
{
    public ?array $prevSlug = null;

    public ?array $nextSlug = null;

    public ?array $current = null;

    public string $view = 'content.components';

    public string $path = '';

    public array $seo = [];

    public function mount(?string $main = null, ?string $children = null): void
    {
        if ($main) {
            $this->view .= ".{$main}";
        }
        if ($children) {
            $this->view .= ".{$children}";
        }

        $segments = explode('.', $this->view);
        if ($segments[0] === 'livewire') {
            array_shift($segments);
        }
        $this->path = str_replace('/content', '', '/'.implode('/', $segments));

        if (! View::exists($this->view)) {
            abort(404);
        }

        $pagger = SidebarPaginator::getPagger($this->path);
        $this->prevSlug = $pagger['prev'];
        $this->nextSlug = $pagger['next'];
        $this->current = $pagger['current'];
        $this->seo = DocsLayoutData::build($this->current);

        View::share('docsLayoutData', [
            'path' => $this->path,
            'seo' => $this->seo,
        ]);
    }

    #[Layout('layouts::docs')]
    public function render()
    {
        return view($this->view);
    }
}
