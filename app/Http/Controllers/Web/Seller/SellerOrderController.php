<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $boutiqueId = Auth::user()?->boutique?->id;
        if (! $boutiqueId) {
            return back()->with('error', 'Aucune boutique active trouvée pour ce compte vendeur.');
        }

        if (Schema::hasColumn('commandes', 'boutique_id')) {
            $orders = Commande::where('boutique_id', $boutiqueId)
                ->with(['client', 'details.produit'])
                ->latest('date_commande')
                ->paginate(15);
        } else {
            $myProductIds = Produit::where('vendeur_id', Auth::id())->pluck('id');
            $orders = Commande::whereHas('details', function ($q) use ($myProductIds) {
                $q->whereIn('produit_id', $myProductIds);
            })
                ->with(['client', 'details.produit'])
                ->latest('date_commande')
                ->paginate(15);
        }

        $user = Auth::user();
        $sellerCategoryId = $user->vendeur_categorie_id
            ?? Produit::where('vendeur_id', $user->id)->value('categorie_id');
        $categories = Categorie::when($sellerCategoryId, function ($q) use ($sellerCategoryId) {
            $q->where('id', $sellerCategoryId);
        })->orderBy('nom')->get();

        return view('seller.seller', [
            'section' => 'commandes',
            'orders' => $orders,
            'totalSales' => 0, 'totalOrders' => 0, 'activeProducts' => 0,
            'avgRating' => 0, 'recentOrders' => collect(),
            'vendeurProfil' => $user->vendeurProfil,
            'boutique' => $user->boutique,
            'totalReviews' => 0,
            'categories' => $categories,
            'sellerCategoryId' => $sellerCategoryId,
        ]);
    }

    public function updateStatus(Request $request, Commande $order)
    {
        $request->validate([
            'action' => 'required|in:confirmer,livrer',
        ]);

        if (Schema::hasColumn('commandes', 'boutique_id')) {
            $boutiqueId = Auth::user()?->boutique?->id;
            if (! $boutiqueId || (int) $order->boutique_id !== (int) $boutiqueId) {
                abort(403);
            }
        } else {
            $myProductIds = Produit::where('vendeur_id', Auth::id())->pluck('id');
            $belongsToSeller = $order->details()->whereIn('produit_id', $myProductIds)->exists();
            if (! $belongsToSeller) {
                abort(403);
            }
        }

        $nextStatus = null;
        if ($request->action === 'confirmer' && $order->statut === 'en_attente') {
            $nextStatus = 'confirmee';
        }
        if ($request->action === 'livrer' && in_array($order->statut, ['confirmee', 'en_preparation', 'en_livraison'], true)) {
            $nextStatus = 'livree';
        }
        if (! $nextStatus) {
            return back()->with('error', 'Action non autorisée pour ce statut.');
        }

        $order->update(['statut' => $nextStatus]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
