<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── INSCRIPTION ────────────────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'prenom'       => 'required|string|max:50',
            'nom'          => 'required|string|max:50',
            'email'        => 'required|email|unique:users,email',
            'telephone'    => 'nullable|string|max:20',
            'password'     => ['required', 'confirmed', Password::min(8)],
            'type_compte'  => 'required|in:client,vendeur',
            'nom_boutique' => 'required_if:type_compte,vendeur|nullable|string|max:100',
            'description_boutique' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'nom'         => trim($request->prenom . ' ' . $request->nom),
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'password'    => Hash::make($request->password),
            'type_compte' => $request->type_compte,
            'statut'      => 'actif',
        ]);

        // Créer le profil spécifique au rôle
        if ($user->type_compte === 'client') {
            DB::table('clients')->insert([
                'user_id'    => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($user->type_compte === 'vendeur') {
            DB::table('vendeurs')->insert([
                'user_id'               => $user->id,
                'nom_boutique'          => $request->nom_boutique,
                'description_boutique'  => $request->description_boutique,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }

        Auth::login($user);

        return match($user->type_compte) {
            'client'  => redirect()->route('buyer.home')
                            ->with('success', 'Bienvenue sur NexShop !'),
            'vendeur' => redirect()->route('seller.home')
                            ->with('success', 'Votre boutique est créée !'),
            default   => redirect()->route('home'),
        };
    }

    // ── CONNEXION ────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        $user = Auth::user();

        // Vérifier que le compte est actif
        if ($user->statut !== 'actif') {
            Auth::logout();
            return back()->with('error', 'Votre compte est suspendu. Contactez le support.');
        }

        $request->session()->regenerate();

        return match($user->type_compte) {
            'client'  => redirect()->route('buyer.home'),
            'vendeur' => redirect()->route('seller.home'),
            'admin'   => redirect()->route('admin.home'),
            default   => redirect()->route('home'),
        };
    }

    // ── DÉCONNEXION ──────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté.');
    }
}
