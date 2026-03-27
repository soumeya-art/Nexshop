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

        return view('buyer.cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite'   => 'nullable|integer|min:1|max:99',
        ]);

        $produit = Produit::findOrFail($request->produit_id);
        if ($produit->statut !== 'actif' || $produit->stock < 1) {
            return back()->with('error', 'Ce produit n\'est pas disponible.');
        }

        $qty = min($request->input('quantite', 1), $produit->stock);
        $existing = Panier::where('client_id', auth()->id())->where('produit_id', $produit->id)->first();

        if ($existing) {
            $existing->update(['quantite' => min($existing->quantite + $qty, $produit->stock)]);
        } else {
            Panier::create([
                'client_id'  => auth()->id(),
                'produit_id' => $produit->id,
                'quantite'   => $qty,
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
