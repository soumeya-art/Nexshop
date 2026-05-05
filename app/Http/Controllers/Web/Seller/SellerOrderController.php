<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $myProductIds = Produit::where('vendeur_id', Auth::id())->pluck('id');

        $orders = Commande::whereHas('details', function ($q) use ($myProductIds) {
                $q->whereIn('produit_id', $myProductIds);
            })
            ->with(['client', 'details.produit'])
            ->latest('date_commande')
            ->paginate(15);

        return view('seller.seller', [
            'section' => 'commandes',
            'orders'  => $orders,
            'totalSales' => 0, 'totalOrders' => 0, 'activeProducts' => 0,
            'avgRating' => 0, 'recentOrders' => collect(), 'vendeurProfil' => Auth::user()->vendeurProfil,
            'totalReviews' => 0,
        ]);
    }

    public function updateStatus(Request $request, Commande $order)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,en_preparation,en_livraison,livree,annulee',
        ]);

        $order->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
