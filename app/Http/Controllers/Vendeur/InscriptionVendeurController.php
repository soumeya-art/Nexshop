<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Mail\KycSoumisMail;
use App\Mail\NouveauKycAdminMail;
use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\KycVendeur;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class InscriptionVendeurController extends Controller
{
    public function showEtape1()
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('vendeur.inscription.etape1', compact('categories'));
    }

    public function soumettreEtape1(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20|unique:users,telephone',
            'password' => 'required|min:8|confirmed',
            'vendeur_categorie_id' => 'required|exists:categories,id',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'password' => $validated['password'],
            'type_compte' => 'vendeur',
            'vendeur_categorie_id' => $validated['vendeur_categorie_id'],
            'email_verifie' => true,
            'etape_inscription' => 'kyc',
            'statut_kyc' => 'non_soumis',
            'statut' => 'actif',
        ]);

        Vendeur::updateOrCreate(['user_id' => $user->id], []);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('vendeur.inscription.kyc');
    }

    public function showKyc()
    {
        return view('vendeur.inscription.kyc');
    }

    public function soumettreKyc(Request $request)
    {
        $validated = $request->validate([
            'type_piece' => 'required|in:cni,passeport',
            'piece_identite' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'selfie_piece' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'adresse' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        KycVendeur::updateOrCreate(
            ['user_id' => $user->id],
            [
                'type_piece' => $validated['type_piece'],
                'piece_identite' => $request->file('piece_identite')->store('kyc/pieces', 'local'),
                'selfie_piece' => $request->file('selfie_piece')->store('kyc/selfies', 'local'),
                'adresse' => $validated['adresse'] ?? null,
            ]
        );

        $user->update([
            'statut_kyc' => 'en_attente',
            'etape_inscription' => 'boutique',
        ]);

        Mail::to($user->email)->send(new KycSoumisMail($user));
        $adminAddress = env('MAIL_ADMIN_ADDRESS', 'admin-demo@nexshop.test');
        Mail::to($adminAddress)->send(new NouveauKycAdminMail($user));

        return redirect()->route('vendeur.inscription.boutique');
    }

    public function showBoutique()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }
        if (in_array($user->etape_inscription, ['compte', 'kyc'], true)) {
            return redirect()->route('vendeur.inscription.kyc');
        }

        $user->loadMissing('vendeurCategorie');
        $categories = Categorie::orderBy('nom')->get();
        $categoriePrefill = $user->vendeurCategorie?->nom;

        return view('vendeur.inscription.boutique', compact('categories', 'categoriePrefill'));
    }

    public function soumettreBoutique(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:boutiques,nom',
            'description' => 'required|string|min:20|max:500',
            'categorie' => ['required', 'string', 'max:100', Rule::exists('categories', 'nom')],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ville' => 'nullable|string|max:100',
            'telephone_boutique' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $logo = $request->hasFile('logo')
            ? Boutique::storePublicImage($request->file('logo'), 'logos')
            : null;

        Boutique::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nom' => $validated['nom'],
                'description' => $validated['description'],
                'categorie' => $validated['categorie'],
                'logo' => $logo,
                'ville' => $validated['ville'] ?? 'Djibouti',
                'telephone_boutique' => $validated['telephone_boutique'] ?? null,
                'est_active' => false,
            ]
        );

        Vendeur::updateOrCreate(
            ['user_id' => $user->id],
            ['nom_boutique' => $validated['nom'], 'description_boutique' => $validated['description']]
        );

        $user->update(['etape_inscription' => 'termine']);

        return redirect()->route('vendeur.attente');
    }

    public function confirmation()
    {
        return view('vendeur.inscription.confirmation');
    }

    public function attente()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->statut_kyc === 'valide') {
            return redirect()->route('vendeur.home');
        }

        if ($user->statut_kyc === 'rejete') {
            return redirect()->route('vendeur.inscription.kyc')
                ->with('rejet', $user->motif_rejet_kyc);
        }

        return view('vendeur.attente', compact('user'));
    }
}
