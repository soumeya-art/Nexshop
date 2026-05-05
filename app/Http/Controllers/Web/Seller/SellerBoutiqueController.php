<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerBoutiqueController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $boutique = $user->boutique;

        if (! $boutique) {
            return redirect()
                ->route('vendeur.inscription.boutique')
                ->with('error', 'Complétez d’abord la fiche de votre boutique.');
        }

        $vendeurProfil = $user->vendeurProfil;
        $categorieLabel = $user->vendeurCategorie?->nom;

        return view('seller.boutique.edit', compact('boutique', 'vendeurProfil', 'categorieLabel'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $boutique = $user->boutique;

        if (! $boutique) {
            return redirect()
                ->route('vendeur.inscription.boutique')
                ->with('error', 'Complétez d’abord la fiche de votre boutique.');
        }

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
                Rule::unique('boutiques', 'nom')->ignore($boutique->id),
            ],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'ville' => ['nullable', 'string', 'max:100'],
            'telephone_boutique' => ['nullable', 'string', 'max:25'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'snapchat_url' => ['nullable', 'string', 'max:255'],
            'tiktok_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'banniere' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = [
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'ville' => $validated['ville'] ?? $boutique->ville,
            'telephone_boutique' => $validated['telephone_boutique'] ?? null,
            'instagram_url' => $this->normalizeSocialUrl($validated['instagram_url'] ?? null, 'https://instagram.com/'),
            'snapchat_url' => $this->normalizeSocialUrl($validated['snapchat_url'] ?? null, 'https://snapchat.com/add/'),
            'tiktok_url' => $this->normalizeSocialUrl($validated['tiktok_url'] ?? null, 'https://www.tiktok.com/@'),
            'youtube_url' => $this->normalizeSocialUrl($validated['youtube_url'] ?? null, 'https://youtube.com/@'),
        ];

        if ($user->vendeurCategorie) {
            $data['categorie'] = $user->vendeurCategorie->nom;
        }

        if ($request->hasFile('logo')) {
            Boutique::deleteStoredPath($boutique->logo);
            $data['logo'] = Boutique::storePublicImage($request->file('logo'), 'logos');
        }

        if ($request->hasFile('banniere')) {
            Boutique::deleteStoredPath($boutique->banniere);
            $data['banniere'] = Boutique::storePublicImage($request->file('banniere'), 'bannieres');
        }

        $boutique->update($data);

        Vendeur::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nom_boutique' => $validated['nom'],
                'description_boutique' => $validated['description'],
            ]
        );

        return redirect()
            ->route('vendeur.boutique.edit')
            ->with('success', 'Boutique mise à jour.');
    }

    private function normalizeSocialUrl(?string $value, string $prefix): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $handle = ltrim($value, '@/');
        if ($handle === '') {
            return null;
        }

        return $prefix.$handle;
    }
}
