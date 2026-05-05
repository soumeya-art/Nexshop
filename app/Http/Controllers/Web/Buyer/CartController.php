<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()->panier()->with('produit')->get();
        $total = $items->sum(fn ($item) => $item->produit->prix * $item->quantite);
        $deliveryConfig = config('nexshop.delivery', []);
        $deliveryFees = [
            'city' => (float) ($deliveryConfig['city_fee_fdj'] ?? 500),
            'region' => (float) ($deliveryConfig['region_fee_fdj'] ?? 1000),
            'free_threshold' => (float) ($deliveryConfig['free_delivery_subtotal_fdj'] ?? 10000),
        ];

        return view('buyer.cart.index', compact('items', 'total', 'deliveryFees'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'nullable|integer|min:1|max:99',
        ]);

        $produit = Produit::with('vendeur')->findOrFail($request->produit_id);
        if ($produit->statut !== 'actif' || $produit->stock < 1) {
            return back()->with('error', 'Ce produit n\'est pas disponible.');
        }
        $vendeur = $produit->vendeur;
        if ($vendeur && ! $vendeur->sellerAcceptsNewOrders()) {
            return back()->with('error', 'Ce vendeur ne peut pas recevoir de nouvelles commandes pour le moment (limite Free ou abonnement expiré).');
        }

        $qty = min($request->input('quantite', 1), $produit->stock);
        $existing = Panier::where('client_id', auth()->id())->where('produit_id', $produit->id)->first();

        if ($existing) {
            $existing->update(['quantite' => min($existing->quantite + $qty, $produit->stock)]);
        } else {
            Panier::create([
                'client_id' => auth()->id(),
                'produit_id' => $produit->id,
                'quantite' => $qty,
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, Panier $cart)
    {
        if ($cart->client_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['quantite' => 'required|integer|min:1|max:99']);
        $cart->update(['quantite' => min($request->quantite, $cart->produit->stock)]);

        return back()->with('success', 'Panier mis à jour.');
    }

    public function remove(Panier $cart)
    {
        if ($cart->client_id !== auth()->id()) {
            abort(403);
        }
        $cart->delete();

        return back()->with('success', 'Article retiré du panier.');
    }
}
