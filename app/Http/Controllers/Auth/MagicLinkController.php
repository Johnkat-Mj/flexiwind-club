<?php

namespace App\Http\Controllers\Auth;

use App\Auth\MagicLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends Controller
{
    public function __construct(private readonly MagicLink $magicLink) {}

    /**
     * Le lien lui-même. La route porte le middleware `signed` ; la vraie
     * preuve reste le secret comparé au hash en base.
     */
    public function show(Request $request, int $link, string $token): RedirectResponse
    {
        $user = $this->magicLink->consume($link, $token, $request);

        if ($user === null) {
            return redirect()->route('login')->with(
                'status.error',
                'That sign-in link is no longer valid. Request a new one below.',
            );
        }

        // Reprise d'un achat interrompu par la connexion.
        if ($plan = $request->session()->pull('checkout.plan')) {
            return redirect()->route('checkout.show', ['plan' => $plan]);
        }

        return redirect()->intended(route('account'))
            ->with('status.sent', 'You are signed in.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pages.home-page');
    }
}
