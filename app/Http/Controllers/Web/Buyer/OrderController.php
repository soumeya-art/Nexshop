<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\PlateformeTemoignage;
use App\Models\User;
use App\Notifications\SellerSubscriptionOrderLimitReached;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->commandes()->with('details.produit')->latest('date_commande')->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }
        $order->load('details.produit');

        $user = auth()->user();
        $showPlatformFeedbackModal = false;
        if ($user->isClient() && ! PlateformeTemoignage::where('user_id', $user->id)->exists()) {
            $promptId = (int) session('platform_feedback_prompt_order_id', 0);
            $dismissed = session('platform_feedback_dismissed_for_order_'.$order->id, false);
            $showPlatformFeedbackModal = $promptId === (int) $order->id && ! $dismissed;
        }

        return view('buyer.orders.show', compact('order', 'showPlatformFeedbackModal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string|max:500',
            'zone_livraison' => 'required|in:djibouti_ville,region',
        ]);

        $items = auth()->user()->panier()->with(['produit.vendeur.boutique'])->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Votre panier est vide.');
        }

        foreach ($items as $item) {
            if ($item->produit->statut !== 'actif') {
                return back()->with('error', 'Le produit « '.$item->produit->nom.' » n’est plus en vente.');
            }
            if ($item->produit->stock < $item->quantite) {
                return back()->with('error', "Stock insuffisant pour : {$item->produit->nom}.");
            }
            $vendeur = $item->produit->vendeur;
            if ($vendeur && ! $vendeur->sellerAcceptsNewOrders()) {
                $label = $vendeur->boutique?->nom ?? $vendeur->nom;

                return back()->with('error', 'La boutique « '.$label.' » ne peut pas recevoir de nouvelles commandes (limite du plan Free ou abonnement expiré). Retirez ses articles du panier ou contactez le vendeur.');
            }
            if (! $vendeur || ! $vendeur->boutique) {
                return back()->with('error', 'Le produit « '.$item->produit->nom.' » n’est pas rattaché à une boutique valide.');
            }
        }

        $deliveryConfig = config('nexshop.delivery', []);
        $cityFee = (float) ($deliveryConfig['city_fee_fdj'] ?? 500);
        $regionFee = (float) ($deliveryConfig['region_fee_fdj'] ?? 1000);
        $freeThreshold = (float) ($deliveryConfig['free_delivery_subtotal_fdj'] ?? 10000);

        /** @var \Illuminate\Support\Collection<int, \Illuminate\Support\Collection> $linesByBoutique */
        $linesByBoutique = $items->groupBy(function ($cartLine) {
            return (int) $cartLine->produit->vendeur->boutique->id;
        });

        $createdOrderIds = [];
        $sellerIdsAlreadyNotifiedBound = [];

        DB::transaction(function () use (
            $linesByBoutique,
            $request,
            &$createdOrderIds,
            &$sellerIdsAlreadyNotifiedBound,
            $cityFee,
            $regionFee,
            $freeThreshold
        ) {
            foreach ($linesByBoutique as $boutiqueId => $groupItems) {
                $subtotal = 0;
                foreach ($groupItems as $cartLine) {
                    $subtotal += $cartLine->produit->prix * $cartLine->quantite;
                }
                $deliveryFee = 0.0;
                if ($subtotal < $freeThreshold) {
                    $deliveryFee = $request->zone_livraison === 'region' ? $regionFee : $cityFee;
                }
                $total = $subtotal + $deliveryFee;

                $order = Commande::create([
                    'client_id' => auth()->id(),
                    'boutique_id' => $boutiqueId,
                    'montant_total' => $total,
                    'statut' => 'en_attente',
                    'adresse_livraison' => $request->adresse_livraison,
                    'zone_livraison' => $request->zone_livraison,
                    'frais_livraison' => $deliveryFee,
                    'mode_paiement' => 'especes',
                    'statut_paiement' => 'en_attente',
                    'date_commande' => now(),
                ]);
                $createdOrderIds[] = $order->id;

                foreach ($groupItems as $cartLine) {
                    CommandeDetail::create([
                        'commande_id' => $order->id,
                        'produit_id' => $cartLine->produit_id,
                        'quantite' => $cartLine->quantite,
                        'prix_unitaire' => $cartLine->produit->prix,
                    ]);
                    $cartLine->produit->decrement('stock', $cartLine->quantite);
                }

                foreach ($groupItems->pluck('produit.vendeur_id')->unique()->filter() as $sellerId) {
                    $seller = User::find($sellerId);
                    if (! $seller || $seller->hasActivePaidSubscription()) {
                        continue;
                    }
                    if ($seller->sellerMonthlyOrderCount() !== $seller->sellerFreeMonthlyLimit()) {
                        continue;
                    }
                    if (isset($sellerIdsAlreadyNotifiedBound[(int) $sellerId])) {
                        continue;
                    }
                    $sellerIdsAlreadyNotifiedBound[(int) $sellerId] = true;
                    $seller->notify(new SellerSubscriptionOrderLimitReached($seller->sellerFreeMonthlyLimit()));
                }
            }

            auth()->user()->panier()->delete();
        });

        $user = auth()->user();
        $shouldPromptPlatformFeedback = $user->isClient()
            && ! PlateformeTemoignage::where('user_id', $user->id)->exists();
        if ($shouldPromptPlatformFeedback && $createdOrderIds !== []) {
            session(['platform_feedback_prompt_order_id' => $createdOrderIds[0]]);
        }

        $single = count($createdOrderIds) === 1;
        $redirectOrderId = $createdOrderIds[0];
        $message = $single
            ? 'Commande enregistrée. Paiement à la livraison.'
            : (''.count($createdOrderIds).' commandes enregistrées (une par boutique). Paiement à la livraison.');

        if ($single) {
            return redirect()->route('buyer.orders.show', $redirectOrderId)
                ->with('success', $message);
        }

        return redirect()->route('buyer.orders.index')
            ->with('success', $message);
    }

    public function cancel(Commande $order)
    {
        if ($order->client_id !== auth()->id()) {
            abort(403);
        }

        if ($order->statut !== 'en_attente') {
            return back()->with('error', 'Seules les commandes en attente peuvent être annulées.');
        }

        foreach ($order->details as $detail) {
            $detail->produit->increment('stock', $detail->quantite);
        }

        $order->update(['statut' => 'annulee']);

        return back()->with('success', 'Commande annulée.');
    }
}
