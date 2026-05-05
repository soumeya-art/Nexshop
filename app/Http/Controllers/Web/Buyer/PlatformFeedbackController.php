<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\PlateformeTemoignage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlatformFeedbackController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->isClient(), 403);

        if (PlateformeTemoignage::where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Vous avez déjà partagé un avis sur la plateforme.');
        }

        $hasOrder = Commande::where('client_id', $user->id)
            ->where('statut', '!=', 'annulee')
            ->exists();

        abort_unless($hasOrder, 403);

        $validated = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['required', 'string', 'min:15', 'max:2000'],
        ]);

        PlateformeTemoignage::create([
            'user_id' => $user->id,
            'note' => $validated['note'],
            'commentaire' => trim($validated['commentaire']),
            'statut' => 'approuve',
        ]);

        $request->session()->forget('platform_feedback_prompt_order_id');

        return back()->with('success', 'Merci ! Votre avis apparaîtra sur la page d’accueil.');
    }

    public function dismiss(Request $request): RedirectResponse
    {
        $request->validate([
            'commande_id' => ['required', 'integer', Rule::exists('commandes', 'id')],
        ]);

        $order = Commande::findOrFail((int) $request->commande_id);
        abort_unless($order->client_id === $request->user()->id, 403);

        $request->session()->put('platform_feedback_dismissed_for_order_'.$order->id, true);
        $request->session()->forget('platform_feedback_prompt_order_id');

        return back()->with('info', 'Pas de souci — on vous redemandera après une prochaine commande.');
    }
}
