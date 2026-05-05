<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Categorie;
use App\Models\Favori;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request, User $seller)
    {
        $query = Produit::with(['categorie'])
            ->actif()
            ->where('vendeur_id', $seller->id);

        abort_if(! $query->exists(), 404);

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Categorie::whereIn('id', function ($sub) use ($seller) {
            $sub->select('categorie_id')->from('produits')->where('vendeur_id', $seller->id);
        })->orderBy('nom')->get();

        $avgRating = Avis::where('statut', 'approuve')
            ->whereIn('produit_id', function ($sub) use ($seller) {
                $sub->select('id')->from('produits')->where('vendeur_id', $seller->id);
            })
            ->avg('note') ?? 0;
        $sellerFavoritesCount = Favori::whereIn('produit_id', function ($sub) use ($seller) {
            $sub->select('id')->from('produits')->where('vendeur_id', $seller->id);
        })->count();
        $isFollowingSeller = $request->user()->followedSellers()->where('seller_id', $seller->id)->exists();

        $seller->load('boutique');

        return view('buyer.products.store', compact('seller', 'products', 'categories', 'avgRating', 'sellerFavoritesCount', 'isFollowingSeller'));
    }

    public function index(Request $request)
    {
        $query = Produit::with(['categorie', 'vendeur'])
            ->actif();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('produits.nom', 'like', '%'.$request->q.'%')
                    ->orWhere('produits.description', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('categorie')) {
            $query->where('produits.categorie_id', $request->categorie);
        }

        $products = $query->orderBySellerSubscriptionPriority()->paginate(12);
        $categories = Categorie::orderBy('nom')->get();

        return view('buyer.products.index', compact('products', 'categories'));
    }

    public function show(Produit $product)
    {
        abort_unless($product->statut === 'actif', 404);

        $product->load(['categorie', 'vendeur.boutique', 'avis' => fn ($q) => $q->where('statut', 'approuve')->latest('date_avis')]);
        $inFavorites = auth()->user()->favoris()->where('produit_id', $product->id)->exists();
        $userReview = auth()->user()->avis()->where('produit_id', $product->id)->first();
        $relatedProducts = Produit::with(['categorie'])
            ->actif()
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('categorie_id', $product->categorie_id)
                    ->orWhere('vendeur_id', $product->vendeur_id);
            })
            ->latest()
            ->limit(8)
            ->get();
        $sellerProductCount = Produit::where('vendeur_id', $product->vendeur_id)->actif()->count();
        $sellerFavoritesCount = Favori::whereIn('produit_id', function ($query) use ($product) {
            $query->select('id')->from('produits')->where('vendeur_id', $product->vendeur_id);
        })->count();
        $sellerRating = Avis::where('statut', 'approuve')
            ->whereIn('produit_id', function ($query) use ($product) {
                $query->select('id')->from('produits')->where('vendeur_id', $product->vendeur_id);
            })
            ->avg('note') ?? 0;
        $isFollowingSeller = auth()->user()->followedSellers()->where('seller_id', $product->vendeur_id)->exists();

        return view('buyer.products.show', compact(
            'product',
            'inFavorites',
            'userReview',
            'relatedProducts',
            'sellerProductCount',
            'sellerFavoritesCount',
            'sellerRating',
            'isFollowingSeller'
        ));
    }

    public function storeReview(Request $request, Produit $product)
    {
        abort_unless($product->statut === 'actif', 404);

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Avis::updateOrCreate(
            [
                'produit_id' => $product->id,
                'client_id' => auth()->id(),
            ],
            [
                'note' => $request->note,
                'commentaire' => $request->commentaire,
                'statut' => 'en_attente',
                'date_avis' => now(),
            ]
        );

        return back()->with('success', 'Votre avis a bien été enregistré.');
    }
}
