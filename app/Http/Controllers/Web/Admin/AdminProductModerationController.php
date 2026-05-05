<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerNotification;
use App\Models\Produit;
use App\Notifications\SellerProductRejected;
use App\Notifications\SellerProductValidated;
use Illuminate\Http\Request;

class AdminProductModerationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'en_attente');
        if (! in_array($tab, ['en_attente', 'rejetes'], true)) {
            $tab = 'en_attente';
        }

        $base = Produit::with(['vendeur', 'categorie'])->latest();

        if ($tab === 'en_attente') {
            $produits = (clone $base)->where('statut', 'en_attente_admin')->paginate(15)->withQueryString();
        } else {
            $produits = (clone $base)->where('statut', 'inactif')->paginate(15)->withQueryString();
        }

        return view('admin.admin', [
            'section' => 'products_moderation',
            'productModerationTab' => $tab,
            'moderationProducts' => $produits,
            'moderationProductsCounts' => [
                'en_attente' => Produit::where('statut', 'en_attente_admin')->count(),
                'rejetes' => Produit::where('statut', 'inactif')->count(),
            ],
            'totalSales' => 0, 'activeUsers' => 0, 'pendingReviews' => 0,
            'categoriesCount' => 0, 'salesTrend' => 0, 'usersTrend' => 0,
            'chartLabels' => [], 'chartData' => [], 'donutLabels' => [], 'donutData' => [],
        ]);
    }

    public function approve(Produit $product)
    {
        abort_unless($product->statut === 'en_attente_admin', 404);

        $newStatut = $product->stock > 0 ? 'actif' : 'rupture';
        $product->update(['statut' => $newStatut]);

        $seller = $product->vendeur;
        $seller->notify(new SellerProductValidated($product));

        $followers = $seller->followers()->pluck('users.id');
        foreach ($followers as $buyerId) {
            BuyerNotification::create([
                'buyer_id' => $buyerId,
                'seller_id' => $seller->id,
                'produit_id' => $product->id,
                'titre' => 'Nouveau produit disponible',
                'message' => $seller->nom.' a ajoute "'.$product->nom.'" dans sa boutique.',
                'lu' => false,
            ]);
        }

        return back()->with('success', 'Le produit a été validé et publié.');
    }

    public function reject(Request $request, Produit $product)
    {
        abort_unless($product->statut === 'en_attente_admin', 404);

        $motif = $request->validate([
            'motif' => ['nullable', 'string', 'max:500'],
        ])['motif'] ?? null;

        $product->update(['statut' => 'inactif']);

        $product->vendeur->notify(new SellerProductRejected($product, $motif));

        return back()->with('success', 'Le produit a été refusé. Le vendeur a été notifié.');
    }
}
