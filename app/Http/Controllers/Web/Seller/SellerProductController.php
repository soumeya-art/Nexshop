<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::with('categorie')
            ->where('vendeur_id', Auth::id());

        if ($request->filled('q')) {
            $query->where('nom', 'like', '%' . $request->q . '%');
        }

        $produits = $query->latest()->paginate(10);
        $categories = Categorie::orderBy('nom')->get();

        return view('seller.seller', [
            'section'    => 'produits',
            'produits'   => $produits,
            'categories' => $categories,
            'totalSales' => 0, 'totalOrders' => 0, 'activeProducts' => 0,
            'avgRating' => 0, 'recentOrders' => collect(), 'vendeurProfil' => Auth::user()->vendeurProfil,
            'totalReviews' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:200',
            'description'  => 'required|string|max:2000',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image_principale' => 'nullable|string|max:500',
        ]);

        Produit::create([
            'vendeur_id'       => Auth::id(),
            'categorie_id'     => $request->categorie_id,
            'nom'              => $request->nom,
            'description'      => $request->description,
            'prix'             => $request->prix,
            'stock'            => $request->stock,
            'image_principale' => $request->image_principale,
            'statut'           => $request->stock > 0 ? 'actif' : 'rupture',
        ]);

        return back()->with('success', 'Produit ajouté avec succès.');
    }

    public function update(Request $request, Produit $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nom'          => 'required|string|max:200',
            'description'  => 'required|string|max:2000',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image_principale' => 'nullable|string|max:500',
        ]);

        $product->update([
            'categorie_id'     => $request->categorie_id,
            'nom'              => $request->nom,
            'description'      => $request->description,
            'prix'             => $request->prix,
            'stock'            => $request->stock,
            'image_principale' => $request->image_principale,
            'statut'           => $request->stock > 0 ? 'actif' : 'rupture',
        ]);

        return back()->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();
        return back()->with('success', 'Produit supprimé avec succès.');
    }
}
