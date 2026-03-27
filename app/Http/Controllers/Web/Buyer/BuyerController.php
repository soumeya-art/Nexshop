<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function home(Request $request)
    {
        $query = Produit::with(['categorie', 'vendeur'])
            ->where('statut', 'actif');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        $products = $query->latest()->paginate(12);
        $categories = Categorie::orderBy('nom')->get();

        return view('buyer.home', compact('products', 'categories'));
    }
}
