<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use Illuminate\Http\Request;

class AdminModerationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'en_attente');
        if (! in_array($tab, ['en_attente', 'approuve', 'refuse'], true)) {
            $tab = 'en_attente';
        }

        $query = Avis::with(['produit', 'client'])->where('statut', $tab);

        $avis = $query->latest('date_avis')->paginate(15)->withQueryString();

        $moderationCounts = [
            'en_attente' => Avis::where('statut', 'en_attente')->count(),
            'approuve' => Avis::where('statut', 'approuve')->count(),
            'refuse' => Avis::where('statut', 'refuse')->count(),
        ];

        return view('admin.admin', [
            'section' => 'moderation',
            'moderationTab' => $tab,
            'moderationCounts' => $moderationCounts,
            'avis' => $avis,
            'totalSales' => 0, 'activeUsers' => 0, 'pendingReviews' => 0,
            'categoriesCount' => 0, 'salesTrend' => 0, 'usersTrend' => 0,
            'chartLabels' => [], 'chartData' => [], 'donutLabels' => [], 'donutData' => [],
        ]);
    }

    public function approve(Avis $avi)
    {
        $avi->update(['statut' => 'approuve']);

        return back()->with('success', 'Avis approuvé.');
    }

    public function reject(Avis $avi)
    {
        $avi->update(['statut' => 'refuse']);

        return back()->with('success', 'Avis refusé.');
    }
}
