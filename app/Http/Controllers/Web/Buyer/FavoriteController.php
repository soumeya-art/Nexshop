<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Favori;
use App\Models\Produit;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favoris = auth()->user()->favoris()->with('produit.categorie')->latest('date_ajout')->get();

        return view('buyer.favorites.index', compact('favoris'));
    }

    public function toggle(Request $request, Produit $product)
    {
        $fav = Favori::where('client_id', auth()->id())->where('produit_id', $product->id)->first();

        if ($fav) {
            $fav->delete();
            $message = 'Retiré des favoris.';
        } else {
            Favori::create([
                'client_id'  => auth()->id(),
                'produit_id' => $product->id,
                'date_ajout' => now(),
            ]);
            $message = 'Ajouté aux favoris.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
