<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVendeurValide
{
    /**
     * Bloque l’espace vendeur opérationnel tant que l’admin n’a pas validé le KYC.
     * L’inscription (/vendeur/inscription) et la page d’attente restent accessibles via d’autres routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isVendeur()) {
            return $next($request);
        }

        if ($user->statut_kyc === 'valide') {
            return $next($request);
        }

        $etape = $user->etape_inscription ?? 'compte';

        if ($etape !== 'termine') {
            return redirect()
                ->route('vendeur.inscription.index')
                ->with('warning', 'Terminez votre inscription vendeur pour accéder à l’espace.');
        }

        if ($user->statut_kyc === 'rejete') {
            return redirect()
                ->route('vendeur.inscription.kyc')
                ->with('rejet', $user->motif_rejet_kyc);
        }

        return redirect()
            ->route('vendeur.attente')
            ->with('info', 'Votre espace vendeur sera accessible une fois votre dossier approuvé par l’administration.');
    }
}
