<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function dashboard(Request $request)
    {
        $section = $request->get('section', 'dashboard');
        $user = Auth::user();

        // KPIs vendeur
        $myProductIds = Produit::where('vendeur_id', $user->id)->pluck('id');

        $totalSales = (float) CommandeDetail::whereIn('produit_id', $myProductIds)
            ->sum(DB::raw('quantite * prix_unitaire'));

        $totalOrders = CommandeDetail::whereIn('produit_id', $myProductIds)
            ->distinct('commande_id')->count('commande_id');

        $activeProducts = Produit::where('vendeur_id', $user->id)
            ->where('statut', 'actif')->count();

        $avgRating = round((float) DB::table('avis')
            ->whereIn('produit_id', $myProductIds)
            ->where('statut', 'approuve')
            ->avg('note'), 1);

        // Commandes récentes
        $recentOrders = Commande::whereHas('details', function ($q) use ($myProductIds) {
                $q->whereIn('produit_id', $myProductIds);
            })
            ->with('client')
            ->latest('date_commande')
            ->limit(5)
            ->get();

        // Profil boutique
        $vendeurProfil = $user->vendeurProfil;
        $totalReviews = DB::table('avis')
            ->whereIn('produit_id', $myProductIds)
            ->where('statut', 'approuve')
            ->count();

        return view('seller.seller', compact(
            'section', 'totalSales', 'totalOrders', 'activeProducts',
            'avgRating', 'recentOrders', 'vendeurProfil', 'totalReviews'
        ));
    }
}
