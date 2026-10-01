<?php

use App\Flexiwind\ChartHelper;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

$visitors = [
    ['month' => 'Jan', 'desktop' => 186, 'mobile' => 80],
    ['month' => 'Feb', 'desktop' => 305, 'mobile' => 200],
    ['month' => 'Mar', 'desktop' => 237, 'mobile' => 120],
];

// ---------------------------------------------------------------- helper

it('rounds the scale to readable ticks', function (): void {
    expect(ChartHelper::niceScale(0, 305))->toMatchArray([
        'min' => 0.0,
        'max' => 400.0,
        'ticks' => [0.0, 100.0, 200.0, 300.0, 400.0],
    ]);
});

it('keeps zero inside the scale for negative values', function (): void {
    $chart = ChartHelper::make([['m' => 'a', 'v' => 40], ['m' => 'b', 'v' => -25]]);

    expect($chart['scale']['min'])->toBeLessThan(0)
        ->and($chart['scale']['ticks'])->toContain(0.0);
});

it('reads the category column and the numeric series without config', function () use ($visitors): void {
    $chart = ChartHelper::make($visitors);

    expect($chart['categories'])->toBe(['Jan', 'Feb', 'Mar'])
        ->and(array_column($chart['series'], 'key'))->toBe(['desktop', 'mobile'])
        ->and($chart['series'][1]['color'])->toBe('var(--chart-2)');
});

it('scales a stacked chart on the sum of each stack', function () use ($visitors): void {
    expect(ChartHelper::make($visitors, stacked: true)['scale']['max'])->toBe(600.0)
        ->and(ChartHelper::make($visitors)['scale']['max'])->toBe(400.0);
});

it('draws a negative bar downward from zero', function (): void {
    $chart = ChartHelper::make([['m' => 'a', 'v' => 50], ['m' => 'b', 'v' => -50]]);
    [$up, $down] = ChartHelper::bars($chart);
    $zero = ChartHelper::y(0, $chart['scale']);

    expect($up['top'] + $up['height'])->toEqualWithDelta($zero, 0.01)
        ->and($down['top'])->toEqualWithDelta($zero, 0.01)
        ->and($up['end'])->toBe('top')
        ->and($down['end'])->toBe('bottom');
});

it('rounds only the outer segment of a stack', function () use ($visitors): void {
    $bars = ChartHelper::bars(ChartHelper::make($visitors, stacked: true));

    expect(array_column(array_slice($bars, 0, 2), 'end'))->toBe([null, 'top']);
});

it('breaks a line where a value is missing', function (): void {
    $chart = ChartHelper::make([['d' => 'a', 'v' => 1], ['d' => 'b', 'v' => null], ['d' => 'c', 'v' => 3]]);

    expect(substr_count(ChartHelper::path($chart, 'v', smooth: false), 'M'))->toBe(2);
});

it('formats values for axes and tooltips', function (float $value, string $format, string $expected): void {
    expect(ChartHelper::format($value, $format))->toBe($expected);
})->with([
    [1250, 'compact', '1.3k'],
    [2400000, 'compact', '2.4M'],
    [305, 'compact', '305'],
    [1234.5, 'number', '1,234.5'],
    [12.5, 'percent', '12.5%'],
]);

it('puts the sign before the prefix', function (): void {
    expect(ChartHelper::format(-2000, 'compact', '€'))->toBe('-€2k');
});

it('refuses a color that could smuggle CSS into the style attribute', function (string $color): void {
    expect(ChartHelper::color($color, 0))->toBe('var(--chart-1)');
})->with(['red; background: url(x)', 'url(https://evil.test)', 'red" onmouseover="x', 'expression(alert(1))}']);

it('accepts common CSS color syntaxes', function (string $color): void {
    expect(ChartHelper::color($color, 0))->toBe($color);
})->with(['#6366f1', 'var(--chart-3)', 'oklch(62% 0.2 264 / 0.8)', 'rgb(99 102 241)', 'color-mix(in oklab, var(--primary) 70%, white)']);

it('lays horizontal bars out from the value axis', function (): void {
    $chart = ChartHelper::make([['p' => 'a', 'v' => 50], ['p' => 'b', 'v' => 100]]);
    [$short, $long] = ChartHelper::bars($chart, 0.3, horizontal: true);

    expect($short['left'])->toBe(0.0)
        ->and($long['width'])->toBeGreaterThan($short['width'])
        ->and($long['top'])->toBeGreaterThan($short['top'])
        ->and($long['end'])->toBe('right');
});

it('splits a pie by category and skips empty or negative slices', function (): void {
    $chart = ChartHelper::make([
        ['b' => 'chrome', 'v' => 300],
        ['b' => 'safari', 'v' => 100],
        ['b' => 'none', 'v' => 0],
        ['b' => 'bad', 'v' => -20],
    ], ['chrome' => ['label' => 'Chrome', 'color' => '#111111']]);

    $slices = ChartHelper::slices($chart);

    expect($slices)->toHaveCount(2)
        ->and($slices[0])->toMatchArray(['label' => 'Chrome', 'color' => '#111111', 'percent' => 75.0])
        ->and($slices[1]['color'])->toBe('var(--chart-2)');
});

it('draws a single full slice as a closed circle', function (): void {
    $slices = ChartHelper::slices(ChartHelper::make([['k' => 'all', 'v' => 10]]), inner: 0.6);

    expect(substr_count($slices[0]['path'], 'A'))->toBe(4);
});

it('reads radial progress against max and clamps it', function (): void {
    $rings = ChartHelper::rings(ChartHelper::make([['g' => 'a', 'v' => 25], ['g' => 'b', 'v' => 140]]), max: 50);

    expect(array_column($rings, 'percent'))->toBe([50.0, 100.0])
        ->and($rings[0]['radius'])->toBeGreaterThan($rings[1]['radius']);
});

it('scales a sparkline line on its own range and bars from zero', function (): void {
    $line = ChartHelper::sparkline([10, 20, 30]);
    $bars = ChartHelper::sparkline([10, 20, 30], 'bar');

    expect($line['last'])->toBe(['x' => 100.0, 'y' => 0.0])
        ->and($bars['bars'][0]['height'])->toBeGreaterThan(0.0)
        ->and($bars['bars'][0]['top'] + $bars['bars'][0]['height'])->toEqualWithDelta(100, 0.01);
});

// ---------------------------------------------------------------- rendu

it('renders a complete bar chart with an accessible data table', function () use ($visitors): void {
    $html = Blade::render('<x-ui.chart :data="$data" index="month" label="Visitors" />', ['data' => $visitors]);

    expect($html)
        ->toContain('data-slot="chart-bars"')
        ->toContain('data-slot="chart-tooltip"')
        ->toContain('<caption>Visitors</caption>')
        ->toContain('<th scope="row">Feb</th>')
        ->toContain('data-slot="chart-legend"');
});

it('escapes labels coming from the data', function (): void {
    $html = Blade::render('<x-ui.chart :data="$data" index="name" />', [
        'data' => [['name' => '<script>alert(1)</script>', 'v' => 3]],
    ]);

    expect($html)->not->toContain('<script>alert(1)</script>')
        ->toContain('&lt;script&gt;');
});

it('renders the doc examples', function (string $example): void {
    expect(Blade::render("<x-examples.chart.{$example} />"))->toContain('data-slot="chart"');
})->with([
    'bar-demo', 'bar-stacked', 'bar-negative', 'bar-custom', 'bar-horizontal',
    'line-demo', 'line-linear', 'line-area',
    'pie-demo', 'donut-demo', 'donut-center', 'radial-demo', 'radial-single',
]);

it('renders the sparkline and tracker examples', function (string $example, string $slot): void {
    expect(Blade::render("<x-examples.chart.{$example} />"))->toContain("data-slot=\"{$slot}\"");
})->with([['sparkline-demo', 'sparkline'], ['tracker-demo', 'tracker']]);

it('lists pie categories with their values in the legend', function (): void {
    $html = Blade::render('<x-ui.chart type="pie" :data="$data" index="b" />', [
        'data' => [['b' => 'Chrome', 'v' => 1200], ['b' => 'Safari', 'v' => 800]],
    ]);

    expect($html)->toContain('data-slot="chart-pie"')->toContain('Chrome')->toContain('1.2k');
});

it('describes a sparkline to screen readers', function (): void {
    expect(Blade::render('<x-ui.sparkline :data="[3, 9, 7]" label="Signups" />'))
        ->toContain('aria-label="Signups: from 3 to 7"');
});

it('keeps tracker tooltips readable without hover', function (): void {
    $html = Blade::render('<x-ui.tracker :data="$data" />', ['data' => [['status' => 'error', 'tooltip' => 'Sep 2 — Outage']]]);

    expect($html)->toContain('<span class="sr-only">Sep 2 — Outage</span>')->toContain('var(--destructive)');
});

it('lets a size class replace the default size', function (): void {
    $data = [['m' => 'a', 'v' => 1]];

    expect(Blade::render('<x-ui.chart :data="$data" class="h-32 w-56" />', ['data' => $data]))
        ->not->toContain('h-64')->not->toContain('w-full')
        ->and(Blade::render('<x-ui.chart :data="$data" class="md:h-96" />', ['data' => $data]))
        ->toContain('h-64');
});

it('exposes keyboard and legend hooks on an interactive chart', function () use ($visitors): void {
    $html = Blade::render('<x-ui.chart interactive :data="$data" index="month" />', ['data' => $visitors]);

    expect($html)
        ->toContain('data-chart-interactive')
        ->toContain('tabindex="0"')
        ->toContain('data-chart-toggle="desktop"')
        ->toContain('aria-pressed="true"')
        ->toContain('data-chart-live')
        ->toContain('data-chart-panel');
});

it('renders a single tooltip panel, whatever the number of categories', function (): void {
    $days = array_map(fn (int $i): array => ['day' => "D{$i}", 'a' => $i, 'b' => $i * 2], range(1, 120));
    $html = Blade::render('<x-ui.chart type="line" :data="$data" index="day" />', ['data' => $days]);

    expect(substr_count($html, 'data-chart-panel'))->toBe(1)
        ->and(substr_count($html, 'data-chart-dot'))->toBe(2)
        ->and($html)->not->toContain('data-chart-zone')
        ->toContain('data-count="120"')
        ->toContain('data-layout="point"')
        ->toContain('<th scope="row">D120</th>');
});

it('gives the tooltip the geometry of a horizontal bar chart', function () use ($visitors): void {
    $html = Blade::render('<x-ui.chart horizontal :data="$data" index="month" />', ['data' => $visitors]);

    expect($html)
        ->toContain('data-layout="band"')
        ->toContain('data-horizontal')
        ->toMatch('/data-scale-min="-?[\d.]+" data-scale-max="[\d.]+"/')
        ->not->toContain('data-chart-dot');
});

it('stays a static chart unless asked to be interactive', function () use ($visitors): void {
    $html = Blade::render('<x-ui.chart :data="$data" index="month" />', ['data' => $visitors]);

    expect($html)->not->toContain('data-chart-interactive')->not->toContain('tabindex')->not->toContain('data-chart-toggle');
});

it('does not offer keyboard navigation on a pie', function (): void {
    $html = Blade::render('<x-ui.chart type="pie" interactive :data="$data" index="b" />', [
        'data' => [['b' => 'a', 'v' => 1], ['b' => 'c', 'v' => 2]],
    ]);

    expect($html)->not->toContain('data-chart-interactive');
});

it('keeps raw values in the data table for CSV export', function (): void {
    $html = Blade::render('<x-ui.chart :data="$data" index="m" />', ['data' => [['m' => 'a', 'v' => 1250]]]);

    expect($html)->toContain('data-value="1250"')->toContain('>1.3k</td>');
});

it('renders the interactive example', function (): void {
    expect(Blade::render('<x-examples.chart.interactive />'))
        ->toContain('data-chart-export="#revenue-streams"')
        ->toContain('id="revenue-streams"');
});

it('adds a selection layer to a brush chart and makes it interactive', function () use ($visitors): void {
    $html = Blade::render('<x-ui.chart brush :data="$data" index="month" />', ['data' => $visitors]);

    expect($html)
        ->toContain('data-chart-brush')
        ->toContain('data-chart-interactive')
        ->toContain('data-chart-brush-overlay')
        ->toContain('Hold Shift with the arrow keys');
});

it('zooms the demo on a selected range, relative to what is shown', function (): void {
    Livewire::test('chart-zoom-demo')
        ->call('zoom', 10, 40)
        ->assertSet('from', 10)
        ->assertSet('to', 40)
        ->call('zoom', 5, 10)
        ->assertSet('from', 15)
        ->assertSet('to', 20)
        ->call('zoom', null, null)
        ->assertSet('from', 0)
        ->assertSet('to', 89);
});

it('ignores a range the browser could have forged', function (mixed $start, mixed $end): void {
    Livewire::test('chart-zoom-demo')
        ->call('zoom', $start, $end)
        ->assertSet('from', 0)
        ->assertSet('to', 89);
})->with([
    'negative' => [-5, 10],
    'reversed' => [30, 10],
    'single day' => [12, 12],
    'past the end' => [10, 500],
    'strings' => ['1', '20'],
    'floats' => [1.5, 20.2],
]);

it('keeps the zoom window out of reach of the browser', function (): void {
    Livewire::test('chart-zoom-demo')->set('from', 50);
})->throws(CannotUpdateLockedPropertyException::class);

it('shows an empty state without data', function (): void {
    expect(Blade::render('<x-ui.chart :data="[]" />'))->toContain('No data to display');
});
