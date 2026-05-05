<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->q.'%')
                    ->orWhere('email', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('role')) {
            $query->where('type_compte', $request->role);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.admin', [
            'section' => 'users',
            'users' => $users,
            // KPI placeholders (needed by the layout)
            'totalSales' => 0, 'activeUsers' => 0, 'pendingReviews' => 0,
            'categoriesCount' => 0, 'salesTrend' => 0, 'usersTrend' => 0,
            'chartLabels' => [], 'chartData' => [], 'donutLabels' => [], 'donutData' => [],
        ]);
    }

    public function toggleBan(User $user)
    {
        $user->statut = $user->statut === 'banni' ? 'actif' : 'banni';
        $user->save();

        return back()->with('success', $user->statut === 'banni'
            ? 'Utilisateur banni avec succès.'
            : 'Utilisateur réactivé avec succès.');
    }
}
