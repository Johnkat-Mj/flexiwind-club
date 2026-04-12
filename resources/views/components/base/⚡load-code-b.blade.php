<?php

use Livewire\Component;

new class extends Component {
    public string $name;
    public bool $isSingle;
    public array $data = [];

    private static array $langMap = [
        'blade.php' => 'blade',
        'php' => 'php',
        'js' => 'javascript',
        'ts' => 'typescript',
        'vue' => 'vue',
        'css' => 'css',
        'json' => 'json',
        'html' => 'html',
    ];

    private static function resolveLang(string $path): string
    {
        foreach (self::$langMap as $ext => $lang) {
            if (str_ends_with($path, '.'.$ext)) {
                return $lang;
            }
        }

        return 'plaintext';
    }

    public function mount(string $name): void
    {
        $this->name = $name;
        $registry = config('registry');
        $filePath = $registry[$name] ?? null;

        if ($filePath === null) {
            $this->isSingle = true;
            $this->data = ['code' => '', 'lang' => 'text', 'name' => 'any-.php'];

            return;
        }

        $block_data = cache()->remember("block-data:{$name}", now()->addHours(72), function () use ($filePath) {
            $path = resource_path("pro-club/{$filePath}");

            if (! file_exists($path)) {
                return null;
            }

            return json_decode(file_get_contents($path), true);
        });

        if ($block_data === null) {
            $this->isSingle = true;
            $this->data = ['code' => '', 'lang' => 'text', 'name' => 'any-.php'];

            return;
        }

        $files = $block_data['files'] ?? [];
        $this->isSingle = count($files) === 1;

        if ($this->isSingle) {
            $file = $files[0];
            $target = $file['target'] ?? $file['path'];
            $this->data = [
                'name' => basename($target),
                'code' => $file['content'],
                'lang' => self::resolveLang($target),
            ];

            return;
        }

        $this->data = array_map(fn (array $file) => [
            'name' => basename($file['target'] ?? $file['path']),
            'code' => $file['content'],
            'lang' => self::resolveLang($file['target'] ?? $file['path']),
        ], $files);
    }
};
?>

@if (!$isSingle)
    <livewire:base.load-code-in-tab :data="$data" />
@else
    <livewire:base.single-code-block no-title :data="$data" />
@endif
