<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Favori;
use App\Models\Produit;
use Illuminate\View\View;

class PublicProductController extends Controller
{
    public function show(Produit $product): View
    {
        abort_unless($product->statut === 'actif', 404);

        $product->load(['categorie', 'vendeur.boutique', 'avis' => fn ($q) => $q->where('statut', 'approuve')->latest('date_avis')]);

        $isClient = auth()->check() && auth()->user()->type_compte === 'client';

        $inFavorites = false;
        $userReview = null;
        $isFollowingSeller = false;
        if ($isClient) {
            $inFavorites = auth()->user()->favoris()->where('produit_id', $product->id)->exists();
            $userReview = auth()->user()->avis()->where('produit_id', $product->id)->first();
            $isFollowingSeller = auth()->user()->followedSellers()->where('seller_id', $product->vendeur_id)->exists();
        }

        $relatedProducts = Produit::with(['categorie'])
            ->actif()
            ->where('produits.id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('produits.categorie_id', $product->categorie_id)
                    ->orWhere('produits.vendeur_id', $product->vendeur_id);
            })
            ->orderBySellerSubscriptionPriority()
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

        return view('public.product', compact(
            'product',
            'isClient',
            'inFavorites',
            'userReview',
            'relatedProducts',
            'sellerProductCount',
            'sellerFavoritesCount',
            'sellerRating',
            'isFollowingSeller'
        ));
    }
}
