<?php

use App\Billing\Checkout;
use App\Billing\Plan;
use App\Mcp\Prompts\AddItemPrompt;
use App\Mcp\Resources\SetupGuideResource;
use App\Mcp\Servers\FlexiwindServer;
use App\Mcp\Tools\AccountStatusTool;
use App\Mcp\Tools\GetItemTool;
use App\Mcp\Tools\GetSourceTool;
use App\Mcp\Tools\ReadDocsTool;
use App\Mcp\Tools\SearchCatalogTool;
use App\Mcp\Tools\SearchDocsTool;
use App\Models\ApiToken;
use App\Models\RegistryDownload;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

function mcpUser(bool $pro = false): User
{
    $user = User::factory()->create();

    if ($pro) {
        app(Checkout::class)->markPaid(
            app(Checkout::class)->start($user, Plan::find('solo-lifetime')),
            'sim_mcp',
        );
    }

    return $user->fresh();
}

/** @param  array<string, mixed>  $params */
function mcpCall(string $method, array $params = [], ?string $token = null, array $headers = []): TestResponse
{
    $test = test();

    if ($token !== null) {
        $test->withToken($token);
    }

    return $test->withHeaders($headers)->postJson('/mcp', [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => $method,
        'params' => $params,
    ]);
}

// ---------------------------------------------------------------- outils

it('finds the free and the pro variant of the same block', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(SearchCatalogTool::class, ['query' => 'login01'])
        ->assertOk()
        ->assertSee('php artisan flexi:add login01')
        ->assertSee('php artisan flexi:add @fx/login01');
});

it('marks pro items as not accessible without a subscription', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(SearchCatalogTool::class, ['query' => 'login01', 'tier' => 'pro'])
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('items.0.tier', 'pro')
            ->where('items.0.accessible', false)
            ->etc());
});

it('filters the catalog by kind', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(SearchCatalogTool::class, ['kind' => 'theme', 'limit' => 25])
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('items', fn ($items) => collect($items)->every(fn ($item) => $item['kind'] === 'theme'))
            ->etc());
});

it('describes an item without handing out its code', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(GetItemTool::class, ['name' => 'login01', 'tier' => 'pro'])
        ->assertOk()
        ->assertSee('resources/views/components/auth/login.blade.php')
        ->assertDontSee('<main');
});

it('serves free source to any account', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(GetSourceTool::class, ['name' => 'button'])
        ->assertOk()
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('tier', 'free')
            ->has('files.0.content')
            ->etc());

    expect(RegistryDownload::count())->toBe(0);
});

it('refuses pro source without a subscription, whether the item exists or not', function (string $name): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(GetSourceTool::class, ['name' => $name, 'tier' => 'pro'])
        ->assertHasErrors(['Flexiwind Pro'])
        ->assertDontSee('<main');
})->with(['login01', 'does-not-exist']);

it('serves pro source to a subscriber and records it as an MCP download', function (): void {
    FlexiwindServer::actingAs($user = mcpUser(pro: true))
        ->tool(GetSourceTool::class, ['name' => 'login01', 'tier' => 'pro'])
        ->assertOk()
        ->assertSee('<main');

    $download = RegistryDownload::sole();
    expect($download->channel)->toBe(RegistryDownload::CHANNEL_MCP)
        ->and($download->user_id)->toBe($user->id)
        ->and($download->item)->toBe('login01');
});

it('stops serving pro source once the subscription expires', function (): void {
    $user = mcpUser(pro: true);
    $user->activeSubscription()->forceFill(['ends_at' => now()->subDay()])->save();

    FlexiwindServer::actingAs($user->fresh())
        ->tool(GetSourceTool::class, ['name' => 'login01', 'tier' => 'pro'])
        ->assertHasErrors();
});

it('rejects item names that are not registry names', function (string $name): void {
    FlexiwindServer::actingAs(mcpUser(pro: true))
        ->tool(GetSourceTool::class, ['name' => $name, 'tier' => 'pro'])
        ->assertHasErrors();
})->with(['../../.env', '@fx/login01', 'LOGIN01', 'login01.json', 'a/b', "login01\0"]);

it('rejects an unknown tier', function (): void {
    FlexiwindServer::actingAs(mcpUser(pro: true))
        ->tool(GetSourceTool::class, ['name' => 'login01', 'tier' => 'enterprise'])
        ->assertHasErrors(['Tier must be']);
});

it('finds and reads a documentation page', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(SearchDocsTool::class, ['query' => 'button', 'section' => 'components'])
        ->assertSee('components/button');

    FlexiwindServer::actingAs(mcpUser())
        ->tool(ReadDocsTool::class, ['path' => 'components/button'])
        ->assertOk()
        ->assertSee('# Button');
});

it('only reads pages from the docs index', function (string $path): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(ReadDocsTool::class, ['path' => $path])
        ->assertHasErrors();
})->with(['../../.env', 'components/../../composer', '/etc/passwd', 'components/nope']);

it('reports the account tier without leaking anything else', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->tool(AccountStatusTool::class)
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('tier', 'free')
            ->where('pricing_url', route('pricing'))
            ->etc());

    FlexiwindServer::actingAs(mcpUser(pro: true))
        ->tool(AccountStatusTool::class)
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('tier', 'pro')
            ->where('plan', 'Solo Lifetime')
            ->etc())
        ->assertDontSee(['@example', 'amount', 'token']);
});

it('explains the pro registry setup without asking for the token in chat', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->resource(SetupGuideResource::class)
        ->assertOk()
        ->assertSee(url('/api/v1/pro').'/{name}')
        ->assertSee('Never ask them to paste it into the chat');
});

it('builds the add-item prompt for a pro block', function (): void {
    FlexiwindServer::actingAs(mcpUser())
        ->prompt(AddItemPrompt::class, ['name' => '@fx/login01', 'target' => 'resources/views/auth/login.blade.php'])
        ->assertOk()
        ->assertSee('name "login01" and tier "pro"')
        ->assertSee('FLEXIWIND_TOKEN');
});

// ---------------------------------------------------------------- transport HTTP

it('refuses the MCP endpoint without a token', function (): void {
    mcpCall('tools/list')->assertUnauthorized();
});

it('refuses a revoked token', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent');
    $token->revoke();

    mcpCall('tools/list', token: $token->plainText)->assertUnauthorized();
});

it('lists the read-only tools for a valid token', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent')->plainText;

    $tools = mcpCall('tools/list', token: $token)->assertOk()->json('result.tools');

    expect(collect($tools)->pluck('name')->sort()->values()->all())->toBe([
        'account-status', 'get-item', 'get-source', 'read-docs', 'search-catalog', 'search-docs',
    ])->and(collect($tools)->every(fn ($tool) => $tool['annotations']['readOnlyHint'] ?? false))->toBeTrue();
});

it('runs a tool as the account behind the token', function (): void {
    $token = ApiToken::issue(mcpUser(pro: true), 'agent')->plainText;

    mcpCall('tools/call', ['name' => 'account-status', 'arguments' => []], $token)
        ->assertOk()
        ->assertJsonPath('result.structuredContent.tier', 'pro');
});

it('does not open a session or set cookies', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent')->plainText;

    $response = mcpCall('tools/list', token: $token);

    expect($response->headers->getCookies())->toBeEmpty();
});

it('rejects a browser request from another origin', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent')->plainText;

    mcpCall('tools/list', token: $token, headers: ['Origin' => 'https://evil.example'])->assertForbidden();
    mcpCall('tools/list', token: $token, headers: ['Origin' => config('app.url')])->assertOk();
});

it('rejects an oversized request body', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent')->plainText;

    mcpCall('tools/call', ['name' => 'search-catalog', 'arguments' => ['query' => str_repeat('a', 70_000)]], $token)
        ->assertStatus(413);
});

it('limits each token to 120 calls a minute', function (): void {
    $token = ApiToken::issue(mcpUser(), 'agent')->plainText;

    foreach (range(1, 120) as $i) {
        mcpCall('ping', token: $token)->assertOk();
    }

    mcpCall('ping', token: $token)->assertTooManyRequests();
});
