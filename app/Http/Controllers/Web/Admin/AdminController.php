<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\DemandeRetour;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function adminCounters(): array
    {
        $pendingReviews = Avis::where('statut', 'en_attente')->count();
        $pendingProducts = Produit::where('statut', 'en_attente_admin')->count();
        $pendingKyc = User::where('type_compte', 'vendeur')->where('statut_kyc', 'en_attente')->count();
        $pendingReturns = DemandeRetour::where('statut', 'en_attente')->count();

        return [
            'pendingReviews' => $pendingReviews,
            'pendingProducts' => $pendingProducts,
            'pendingKyc' => $pendingKyc,
            'pendingReturns' => $pendingReturns,
            'adminAlertCount' => $pendingReviews + $pendingProducts + $pendingKyc + $pendingReturns,
        ];
    }

    public function dashboard(Request $request)
    {
        $section = $request->get('section', 'stats');
        $counters = $this->adminCounters();

        // KPIs
        $totalSales = Commande::where('statut_paiement', 'paye')->sum('montant_total');
        $activeUsers = User::where('statut', 'actif')->count();
        $pendingReviews = $counters['pendingReviews'];
        $pendingProducts = $counters['pendingProducts'];
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
        $donutData = $categoryStats->pluck('total')->map(fn ($v) => round($v, 2))->toArray();

        return view('admin.admin', compact(
            'section', 'totalSales', 'activeUsers', 'pendingReviews', 'pendingProducts', 'categoriesCount',
            'salesTrend', 'usersTrend',
            'chartLabels', 'chartData', 'donutLabels', 'donutData'
        ) + [
            'adminAlertCount' => $counters['adminAlertCount'],
        ]);
    }

    public function notifications()
    {
        $section = 'notifications';
        $counters = $this->adminCounters();

        $recentKyc = User::query()
            ->where('type_compte', 'vendeur')
            ->where('statut_kyc', 'en_attente')
            ->latest()
            ->take(12)
            ->get(['id', 'nom', 'email', 'created_at']);

        $recentProducts = Produit::query()
            ->where('statut', 'en_attente_admin')
            ->with('vendeur:id,nom')
            ->latest()
            ->take(12)
            ->get(['id', 'vendeur_id', 'nom', 'created_at']);

        $recentReviews = Avis::query()
            ->where('statut', 'en_attente')
            ->with(['client:id,nom', 'produit:id,nom'])
            ->latest()
            ->take(12)
            ->get(['id', 'produit_id', 'client_id', 'created_at']);

        $recentReturns = DemandeRetour::query()
            ->where('statut', 'en_attente')
            ->with(['client:id,nom', 'produit:id,nom'])
            ->latest()
            ->take(12)
            ->get(['id', 'client_id', 'produit_id', 'created_at']);

        $recentUsers = User::query()
            ->latest()
            ->take(12)
            ->get(['id', 'nom', 'type_compte', 'created_at']);

        return view('admin.admin', [
            'section' => $section,
            'pendingReviews' => $counters['pendingReviews'],
            'pendingProducts' => $counters['pendingProducts'],
            'adminAlertCount' => $counters['adminAlertCount'],
            'recentKyc' => $recentKyc,
            'recentProducts' => $recentProducts,
            'recentReviews' => $recentReviews,
            'recentReturns' => $recentReturns,
            'recentUsers' => $recentUsers,
            // Valeurs par défaut pour la vue admin partagée.
            'totalSales' => 0,
            'activeUsers' => 0,
            'categoriesCount' => Categorie::count(),
            'salesTrend' => 0,
            'usersTrend' => 0,
            'chartLabels' => [],
            'chartData' => [],
            'donutLabels' => [],
            'donutData' => []
        ]);

    }
}
