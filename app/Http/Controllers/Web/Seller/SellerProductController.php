<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $sellerCategoryId = Auth::user()->vendeur_categorie_id
            ?? Produit::where('vendeur_id', Auth::id())->value('categorie_id');
        $query = Produit::with('categorie')
            ->where('vendeur_id', Auth::id());

        if ($request->filled('q')) {
            $query->where('nom', 'like', '%'.$request->q.'%');
        }

        $produits = $query->latest()->paginate(10);
        $categories = Categorie::when($sellerCategoryId, function ($q) use ($sellerCategoryId) {
            $q->where('id', $sellerCategoryId);
        })->orderBy('nom')->get();

        return view('seller.seller', [
            'section' => 'produits',
            'produits' => $produits,
            'categories' => $categories,
            'sellerCategoryId' => $sellerCategoryId,
            'totalSales' => 0, 'totalOrders' => 0, 'activeProducts' => 0,
            'avgRating' => 0, 'recentOrders' => collect(),
            'vendeurProfil' => Auth::user()->vendeurProfil,
            'boutique' => Auth::user()->boutique,
            'totalReviews' => 0,
        ]);
    }

    public function create()
    {
        $sellerCategoryId = Auth::user()->vendeur_categorie_id
            ?? Produit::where('vendeur_id', Auth::id())->value('categorie_id');
        $categories = Categorie::when($sellerCategoryId, function ($q) use ($sellerCategoryId) {
            $q->where('id', $sellerCategoryId);
        })->orderBy('nom')->get();

        return view('seller.products.create', [
            'categories' => $categories,
            'sellerCategoryId' => $sellerCategoryId,
        ]);
    }

    public function store(Request $request)
    {
        $sellerCategoryId = Auth::user()->vendeur_categorie_id
            ?? Produit::where('vendeur_id', Auth::id())->value('categorie_id');

        $request->validate([
            'nom' => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image_principale' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'images_supplementaires' => 'nullable|array|max:4',
            'images_supplementaires.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'videos_supplementaires' => 'nullable|array|max:3',
            'videos_supplementaires.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-msvideo|max:102400',
        ]);

        if ($sellerCategoryId && (int) $request->categorie_id !== (int) $sellerCategoryId) {
            return back()->with('error', 'Vous devez publier uniquement dans la categorie choisie a l inscription.');
        }

        $mainImage = $request->hasFile('image_principale')
            ? $this->storeMediaInPublicImages($request->file('image_principale'), 'img')
            : null;

        $extraImages = [];
        foreach ($request->file('images_supplementaires', []) as $image) {
            if ($image && $image->isValid()) {
                $extraImages[] = $this->storeMediaInPublicImages($image, 'img');
            }
        }

        $extraVideos = [];
        foreach ($request->file('videos_supplementaires', []) as $video) {
            if ($video && $video->isValid()) {
                $extraVideos[] = $this->storeMediaInPublicImages($video, 'vid');
            }
        }

        if (! $mainImage && ! empty($extraImages)) {
            $mainImage = $extraImages[0];
        }

        $product = Produit::create([
            'vendeur_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'image_principale' => $mainImage,
            'images_supplementaires' => $extraImages,
            'videos_supplementaires' => $extraVideos,
            'statut' => 'en_attente_admin',
        ]);

        return redirect()->route('vendeur.products')->with('success', 'Produit enregistré. Il sera visible sur la boutique après validation par l’administrateur.');
    }

    public function update(Request $request, Produit $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403);
        }

        $sellerCategoryId = Auth::user()->vendeur_categorie_id
            ?? Produit::where('vendeur_id', Auth::id())
                ->where('id', '!=', $product->id)
                ->value('categorie_id');

        $request->validate([
            'nom' => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image_principale' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'images_supplementaires' => 'nullable|array',
            'images_supplementaires.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'videos_supplementaires' => 'nullable|array',
            'videos_supplementaires.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-msvideo|max:102400',
        ]);

        if ($sellerCategoryId && (int) $request->categorie_id !== (int) $sellerCategoryId) {
            return back()->with('error', 'Vous devez publier uniquement dans la categorie choisie a l inscription.');
        }

        $mainImage = $product->image_principale;
        if ($request->hasFile('image_principale')) {
            $mainImage = $this->storeMediaInPublicImages($request->file('image_principale'), 'img');
        }

        $extraImages = array_values(array_filter($product->images_supplementaires ?? []));
        if ($request->hasFile('images_supplementaires')) {
            foreach ($request->file('images_supplementaires', []) as $image) {
                if ($image && $image->isValid()) {
                    $extraImages[] = $this->storeMediaInPublicImages($image, 'img');
                }
            }
        }

        $extraVideos = array_values(array_filter($product->videos_supplementaires ?? []));
        if ($request->hasFile('videos_supplementaires')) {
            foreach ($request->file('videos_supplementaires', []) as $video) {
                if ($video && $video->isValid()) {
                    $extraVideos[] = $this->storeMediaInPublicImages($video, 'vid');
                }
            }
        }

        if (in_array($product->statut, ['actif', 'rupture'], true)) {
            $nouveauStatut = $request->stock > 0 ? 'actif' : 'rupture';
        } else {
            $nouveauStatut = 'en_attente_admin';
        }

        $product->update([
            'categorie_id' => $request->categorie_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'image_principale' => $mainImage,
            'images_supplementaires' => $extraImages,
            'videos_supplementaires' => $extraVideos,
            'statut' => $nouveauStatut,
        ]);

        $msg = $nouveauStatut === 'en_attente_admin'
            ? 'Produit mis à jour. Il sera visible après validation par l’administrateur.'
            : 'Produit modifié avec succès.';

        return back()->with('success', $msg);
    }

    public function destroy(Produit $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();

        return back()->with('success', 'Produit supprimé avec succès.');
    }

    private function storeMediaInPublicImages($file, string $prefix): string
    {
        $directory = public_path('images');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $prefix.'_'.Auth::id().'_'.now()->format('YmdHis').'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'images/'.$filename;
    }
}
