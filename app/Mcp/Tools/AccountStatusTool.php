<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

/**
 * Ne dit rien d'autre que ce que le compte connecté sait de lui-même :
 * pas de membres d'équipe, pas de jetons, pas de montants.
 */
#[Name('account-status')]
#[Description('Whether the connected Flexiwind account can use Pro items, and which plan covers it. Call it when a Pro item is refused, or before suggesting Pro items to the user.')]
#[IsReadOnly]
#[IsIdempotent]
class AccountStatusTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $user = $request->user();

        if ($user === null) {
            return Response::error('Not authenticated.');
        }

        $subscription = $user->activeSubscription();

        return Response::structured([
            'tier' => $subscription ? 'pro' : 'free',
            'plan' => $subscription?->planName(),
            'role' => $subscription === null || $subscription->seats <= 1
                ? null
                : ($subscription->isOwnedBy($user) ? 'owner' : 'member'),
            'expires_at' => $subscription?->ends_at?->toIso8601String(),
            'pricing_url' => $subscription ? null : route('pricing'),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
