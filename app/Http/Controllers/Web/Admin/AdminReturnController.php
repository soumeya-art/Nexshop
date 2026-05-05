<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeRetour;
use Illuminate\Http\Request;

class AdminReturnController extends Controller
{
    public function index()
    {
        $returns = DemandeRetour::with(['client', 'produit.vendeur', 'commande'])
            ->latest()
            ->paginate(20);

        $pendingCount = DemandeRetour::where('statut', 'en_attente')->count();

        return view('admin.returns.index', compact('returns', 'pendingCount'));
    }

    public function show(DemandeRetour $retour)
    {
        $retour->load(['client', 'produit.vendeur.boutique', 'commande.details.produit']);

        return view('admin.returns.show', compact('retour'));
    }

    public function contactVendeur(Request $request, DemandeRetour $retour)
    {
        $request->validate([
            'note_admin' => 'nullable|string|max:2000',
        ]);

        $retour->update([
            'statut'     => 'vendeur_contacte',
            'note_admin' => $request->note_admin,
        ]);

        return back()->with('success', 'Le vendeur a été notifié. Statut mis à jour.');
    }

    public function accept(DemandeRetour $retour)
    {
        $retour->update(['statut' => 'acceptee']);

        $retour->produit?->increment('stock', $retour->quantite);

        return back()->with('success', 'Retour accepté. Stock mis à jour.');
    }

    public function reject(Request $request, DemandeRetour $retour)
    {
        $request->validate([
            'note_admin' => 'nullable|string|max:2000',
        ]);

        $retour->update([
            'statut'     => 'refusee',
            'note_admin' => $request->note_admin ?? $retour->note_admin,
        ]);

        return back()->with('success', 'Retour refusé.');
    }
}
