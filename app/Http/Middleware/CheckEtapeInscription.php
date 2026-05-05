<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEtapeInscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user || $user->type_compte !== 'vendeur') {
            return $next($request);
        }

        $etape = $user->etape_inscription ?? 'compte';
        $route = (string) $request->route()?->getName();

        $redirections = [
            'compte' => 'vendeur.inscription.kyc',
            'kyc' => 'vendeur.inscription.kyc',
            'boutique' => 'vendeur.inscription.boutique',
        ];

        if ($etape !== 'termine' && ! str_starts_with($route, 'vendeur.inscription.')) {
            return redirect()->route($redirections[$etape] ?? 'vendeur.inscription.index');
        }

        if ($etape === 'termine' && $user->statut_kyc !== 'valide') {
            if (! str_starts_with($route, 'vendeur.inscription.') && $route !== 'vendeur.home') {
                return redirect()->route('vendeur.home')->with('alerte_kyc', true);
            }
        }

        return $next($request);
    }
}
