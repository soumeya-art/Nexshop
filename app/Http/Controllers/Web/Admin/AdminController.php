<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $section = $request->get('section', 'stats');

        // KPIs
        $totalSales = Commande::where('statut_paiement', 'paye')->sum('montant_total');
        $activeUsers = User::where('statut', 'actif')->count();
        $pendingReviews = Avis::where('statut', 'en_attente')->count();
        $categoriesCount = Categorie::count();

        // Tendances (mois courant vs mois précédent)
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $salesThisMonth = Commande::where('statut_paiement', 'paye')
            ->where('created_at', '>=', $currentMonth)->sum('montant_total');
        $salesLastMonth = Commande::where('statut_paiement', 'paye')
            ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('montant_total');
        $salesTrend = $salesLastMonth > 0 ? round((($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100, 1) : 0;

        $usersThisMonth = User::where('statut', 'actif')->where('created_at', '>=', $currentMonth)->count();
        $usersLastMonth = User::where('statut', 'actif')->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();
        $usersTrend = $usersLastMonth > 0 ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1) : 0;

        // Graphique : transactions des 7 derniers jours
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $chartLabels[] = $day->translatedFormat('D');
            $chartData[] = (float) Commande::whereDate('created_at', $day->toDateString())->sum('montant_total');
        }

        // Donut : répartition ventes par catégorie
        $categoryStats = DB::table('commande_details')
            ->join('produits', 'commande_details.produit_id', '=', 'produits.id')
            ->join('categories', 'produits.categorie_id', '=', 'categories.id')
            ->select('categories.nom', DB::raw('SUM(commande_details.quantite * commande_details.prix_unitaire) as total'))
            ->groupBy('categories.nom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $donutLabels = $categoryStats->pluck('nom')->toArray();
        $donutData = $categoryStats->pluck('total')->map(fn($v) => round($v, 2))->toArray();

        return view('admin.admin', compact(
            'section', 'totalSales', 'activeUsers', 'pendingReviews', 'categoriesCount',
            'salesTrend', 'usersTrend',
            'chartLabels', 'chartData', 'donutLabels', 'donutData'
        ));
    }
}
