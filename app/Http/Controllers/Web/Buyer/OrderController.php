<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Panier;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->commandes()->with('details.produit')->latest('date_commande')->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }
        $order->load('details.produit');

        return view('buyer.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate(['adresse_livraison' => 'required|string|max:500']);

        $items = auth()->user()->panier()->with('produit')->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Votre panier est vide.');
        }

        $total = 0;
        foreach ($items as $item) {
            if ($item->produit->stock < $item->quantite) {
                return back()->with('error', "Stock insuffisant pour : {$item->produit->nom}.");
            }
            $total += $item->produit->prix * $item->quantite;
        }

        $order = Commande::create([
            'client_id'         => auth()->id(),
            'montant_total'    => $total,
            'statut'           => 'en_attente',
            'adresse_livraison' => $request->adresse_livraison,
            'mode_paiement'    => 'especes',
            'statut_paiement'  => 'en_attente',
            'date_commande'    => now(),
        ]);

        foreach ($items as $item) {
            CommandeDetail::create([
                'commande_id'    => $order->id,
                'produit_id'     => $item->produit_id,
                'quantite'       => $item->quantite,
                'prix_unitaire' => $item->produit->prix,
            ]);
            $item->produit->decrement('stock', $item->quantite);
        }

        auth()->user()->panier()->delete();

        return redirect()->route('buyer.orders.show', $order)
            ->with('success', 'Commande enregistrée. Paiement à la livraison.');
    }

    public function cancel(Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }

        if ($order->statut !== 'en_attente') {
            return back()->with('error', 'Seules les commandes en attente peuvent être annulées.');
        }

        foreach ($order->details as $detail) {
            $detail->produit->increment('stock', $detail->quantite);
        }

        $order->update(['statut' => 'annulee']);

        return back()->with('success', 'Commande annulée.');
    }
}
