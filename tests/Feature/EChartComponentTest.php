<?php

use Illuminate\Support\Facades\Blade;

$sales = [
    ['month' => 'Jan', 'revenue' => 1200, 'costs' => 800],
    ['month' => 'Feb', 'revenue' => 1500, 'costs' => 900],
];

/** @return array<string, mixed> */
function echartPayload(string $html): array
{
    preg_match('#<script type="application/json" data-echart-config>(.*?)</script>#s', $html, $match);

    return json_decode(html_entity_decode($match[1] ?? '{}'), true) ?? [];
}

it('hands the plugin a JSON payload built from the shared data model', function () use ($sales): void {
    $payload = echartPayload(Blade::render('<x-ui.echart type="bar" stacked zoom :data="$data" index="month" prefix="€" />', ['data' => $sales]));

    expect($payload)->toMatchArray([
        'type' => 'bar',
        'stacked' => true,
        'zoom' => true,
        'renderer' => 'svg',
        'categories' => ['Jan', 'Feb'],
        'format' => ['style' => 'compact', 'prefix' => '€', 'suffix' => ''],
    ])->and(array_column($payload['series'], 'key'))->toBe(['revenue', 'costs']);
});

it('falls back to a line chart for an unknown type', function () use ($sales): void {
    expect(echartPayload(Blade::render('<x-ui.echart type="nope" :data="$data" index="month" />', ['data' => $sales]))['type'])->toBe('line');
});

it('switches to canvas rendering for large datasets', function (): void {
    $data = array_map(fn (int $i) => ['t' => (string) $i, 'v' => $i], range(1, 2500));

    expect(echartPayload(Blade::render('<x-ui.echart :data="$data" index="t" />', ['data' => $data]))['renderer'])->toBe('canvas');
});

it('cannot close its script tag from the data', function (): void {
    $html = Blade::render('<x-ui.echart :data="$data" index="name" />', [
        'data' => [['name' => '</script><script>alert(1)</script>', 'v' => 1]],
    ]);

    expect(substr_count($html, '</script>'))->toBe(1)
        ->and(echartPayload($html)['categories'][0])->toBe('</script><script>alert(1)</script>');
});

it('keeps a data table for screen readers, summarised past 500 rows', function () use ($sales): void {
    expect(Blade::render('<x-ui.echart :data="$data" index="month" label="Sales" />', ['data' => $sales]))
        ->toContain('<caption>Sales</caption>');

    $large = array_map(fn (int $i) => ['t' => "t{$i}", 'v' => $i], range(1, 600));

    expect(Blade::render('<x-ui.echart :data="$data" index="t" label="Load" />', ['data' => $large]))
        ->not->toContain('<table')
        ->toContain('Load: 600 values from t1 to t600.');
});

it('passes raw ECharts options through, last', function () use ($sales): void {
    $payload = echartPayload(Blade::render('<x-ui.echart :data="$data" index="month" :options="$options" />', [
        'data' => $sales,
        'options' => ['yAxis' => ['min' => 0]],
    ]));

    expect($payload['options'])->toBe(['yAxis' => ['min' => 0]]);
});

it('renders every doc example', function (string $example): void {
    expect(Blade::render("<x-examples.echart.{$example} />"))->toContain('data-slot="echart"');
})->with([
    'bar-simple', 'bar-stacked', 'bar-zoom',
    'line-simple', 'line-area-zoom', 'line-large',
    'pie-simple', 'pie-donut',
    'scatter-simple', 'scatter-groups',
    'radar-simple', 'radar-compare',
    'heatmap-simple', 'heatmap-week',
    'candlestick-simple', 'candlestick-zoom',
    'funnel-simple', 'funnel-options',
]);

it('gives a scatter a numeric axis when the index is numeric', function (): void {
    $payload = echartPayload(Blade::render('<x-ui.echart type="scatter" :data="$data" index="spend" />', [
        'data' => [['spend' => 250, 'signups' => 40], ['spend' => 500, 'signups' => 61]],
    ]));

    expect($payload['numericIndex'])->toBeTrue();
});
