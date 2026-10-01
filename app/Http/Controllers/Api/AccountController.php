<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Ce que la CLI interroge pour dire à l'utilisateur où il en est. */
class AccountController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $subscription = $user->activeSubscription();

        return response()->json([
            'email' => $user->email,
            'name' => $user->name,
            'tier' => $user->hasProAccess() ? 'pro' : 'free',
            'plan' => $subscription?->plan_key,
            'expires_at' => $subscription?->ends_at?->toIso8601String(),
        ]);
    }
}
