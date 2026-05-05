<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use Illuminate\Http\Request;

class AdminModerationController extends Controller
{
    public function index(Request $request)
    {
        $avis = Avis::with(['produit', 'client'])
            ->where('statut', 'en_attente')
            ->latest('date_avis')
            ->paginate(15);

        return view('admin.admin', [
            'section' => 'moderation',
            'avis'    => $avis,
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
