<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\DemandeRetour;
use Illuminate\Http\Request;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $returns = DemandeRetour::where('client_id', auth()->id())
            ->with(['commande', 'produit'])
            ->latest()
            ->paginate(10);

        return view('buyer.returns.index', compact('returns'));
    }

    public function create(Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($order->statut, ['livree', 'confirmee'])) {
            return back()->with('error', 'Vous ne pouvez demander un retour que pour une commande livrée.');
        }

        if ($order->date_livraison && $order->date_livraison->diffInDays(now()) > 5) {
            return back()->with('error', 'Le délai de retour de 5 jours est dépassé.');
        }

        $order->load('details.produit');

        return view('buyer.returns.create', compact('order'));
    }

    public function store(Request $request, Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'produit_id'  => 'required|exists:produits,id',
            'quantite'    => 'required|integer|min:1',
            'motif'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        $detail = CommandeDetail::where('commande_id', $order->id)
            ->where('produit_id', $request->produit_id)
            ->first();

        if (! $detail) {
            return back()->with('error', 'Ce produit ne fait pas partie de cette commande.');
        }

        if ($request->quantite > $detail->quantite) {
            return back()->with('error', 'Quantité demandée supérieure à la quantité commandée.');
        }

        $existing = DemandeRetour::where('commande_id', $order->id)
            ->where('produit_id', $request->produit_id)
            ->whereNotIn('statut', ['refusee'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Une demande de retour existe déjà pour ce produit.');
        }

        DemandeRetour::create([
            'commande_id' => $order->id,
            'client_id'   => auth()->id(),
            'produit_id'  => $request->produit_id,
            'quantite'    => $request->quantite,
            'motif'       => $request->motif,
            'description' => $request->description,
            'statut'      => 'en_attente',
        ]);

        return redirect()->route('buyer.returns.index')
            ->with('success', 'Demande de retour envoyée. L\'admin va contacter le vendeur.');
    }
}
