<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::with(['categorie', 'vendeur'])
            ->where('statut', 'actif');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        $products = $query->latest()->paginate(12);
        $categories = Categorie::orderBy('nom')->get();

        return view('buyer.products.index', compact('products', 'categories'));
    }

    public function show(Produit $product)
    {
        $product->load(['categorie', 'vendeur', 'avis' => fn ($q) => $q->where('statut', 'approuve')->latest('date_avis')]);
        $inFavorites = auth()->user()->favoris()->where('produit_id', $product->id)->exists();
        $userReview = auth()->user()->avis()->where('produit_id', $product->id)->first();

        return view('buyer.products.show', compact('product', 'inFavorites', 'userReview'));
    }

    public function storeReview(Request $request, Produit $product)
    {
        $request->validate([
            'note'       => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Avis::updateOrCreate(
            [
                'produit_id' => $product->id,
                'client_id'  => auth()->id(),
            ],
            [
                'note'       => $request->note,
                'commentaire' => $request->commentaire,
                'statut'     => 'en_attente',
                'date_avis'  => now(),
            ]
        );

        return back()->with('success', 'Votre avis a bien été enregistré.');
    }
}
