<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('produits')->orderBy('nom')->paginate(15);

        return view('admin.admin', [
            'section' => 'categories',
            'categories' => $categories,
            'totalSales' => 0, 'activeUsers' => 0, 'pendingReviews' => 0,
            'categoriesCount' => 0, 'salesTrend' => 0, 'usersTrend' => 0,
            'chartLabels' => [], 'chartData' => [], 'donutLabels' => [], 'donutData' => [],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'icone' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
        ]);

        Categorie::create($request->only('nom', 'description', 'icone', 'image_url'));

        return back()->with('success', 'Catégorie créée avec succès.');
    }

    public function update(Request $request, Categorie $category)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'icone' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
        ]);

        $category->update($request->only('nom', 'description', 'icone', 'image_url'));

        return back()->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $category)
    {
        $category->delete();

        return back()->with('success', 'Catégorie supprimée avec succès.');
    }
}
