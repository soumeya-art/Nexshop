<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceSellerSubscription
{
    /** @var list<string> */
    private const READONLY_GET_ROUTES = [
        'vendeur.home',
        'vendeur.products',
        'vendeur.orders',
        'vendeur.notifications.index',
        'vendeur.boutique.edit',
    ];

    /** @var list<string> */
    private const ALWAYS_ALLOWED = [
        'vendeur.abonnement.index',
        'vendeur.abonnement.checkout',
        'vendeur.abonnement.store',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->isVendeur() || ! $user->sellerSubscriptionLocked()) {
            return $next($request);
        }

        $name = $request->route()?->getName();

        if ($name && in_array($name, self::ALWAYS_ALLOWED, true)) {
            return $next($request);
        }

        if ($request->isMethod('GET') && $name && in_array($name, self::READONLY_GET_ROUTES, true)) {
            return $next($request);
        }

        return redirect()
            ->route('vendeur.abonnement.index')
            ->with('error', 'Votre formule Free a atteint la limite mensuelle ou votre abonnement a expiré. Passez au Pro ou Premium pour continuer.');
    }
}
