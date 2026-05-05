<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KycRejeteMail;
use App\Mail\KycValideMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class KycAdminController extends Controller
{
    public function index()
    {
        $enAttente = User::where('type_compte', 'vendeur')
            ->where('statut_kyc', 'en_attente')
            ->with(['kyc', 'boutique'])
            ->latest()
            ->paginate(20);

        $stats = [
            'en_attente' => User::where('type_compte', 'vendeur')->where('statut_kyc', 'en_attente')->count(),
            'valides' => User::where('type_compte', 'vendeur')->where('statut_kyc', 'valide')->count(),
            'rejetes' => User::where('type_compte', 'vendeur')->where('statut_kyc', 'rejete')->count(),
        ];

        return view('admin.kyc.index', compact('enAttente', 'stats'));
    }

    public function show(User $user)
    {
        abort_unless($user->type_compte === 'vendeur', 404);
        $user->load(['kyc', 'boutique']);

        return view('admin.kyc.show', compact('user'));
    }

    public function valider(User $user)
    {
        abort_unless($user->type_compte === 'vendeur', 404);
        abort_unless($user->statut_kyc === 'en_attente', 403, 'Ce dossier ne peut plus être approuvé dans son état actuel.');

        $user->update([
            'statut_kyc' => 'valide',
            'valide_par' => auth()->id(),
            'valide_at' => now(),
            'motif_rejet_kyc' => null,
        ]);

        $user->boutique?->update(['est_active' => true]);

        Mail::to($user->email)->send(new KycValideMail($user));

        return redirect()->route('admin.kyc.index')->with('success', "Vendeur {$user->nom} valide.");
    }

    public function rejeter(Request $request, User $user)
    {
        abort_unless($user->type_compte === 'vendeur', 404);
        abort_unless($user->statut_kyc === 'en_attente', 403, 'Ce dossier ne peut plus être rejeté dans son état actuel.');
        $request->validate(['motif' => 'required|string|max:500']);

        $user->update([
            'statut_kyc' => 'rejete',
            'motif_rejet_kyc' => $request->motif,
            'valide_par' => auth()->id(),
            'valide_at' => now(),
        ]);

        $user->boutique?->update(['est_active' => false]);

        Mail::to($user->email)->send(new KycRejeteMail($user, $request->motif));

        return redirect()->route('admin.kyc.index')->with('success', 'Dossier rejeté.');
    }

    public function document(User $user, string $type)
    {
        abort_unless($user->type_compte === 'vendeur', 404);
        abort_unless(in_array($type, ['piece_identite', 'selfie_piece'], true), 404);

        $user->load('kyc');
        $path = $user->kyc?->{$type};
        abort_unless($path, 404);

        return Storage::disk('local')->response($path);
    }
}
