<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\SellerSubscriptionPayment;
use App\Models\User;
use App\Notifications\SellerSubscriptionActivated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SellerSubscriptionService
{
    public static function planConfig(string $plan): ?array
    {
        $plans = config('nexshop.seller_subscription.plans', []);

        return $plans[$plan] ?? null;
    }

    public static function priceForPlan(string $plan): int
    {
        if ($plan === 'free') {
            return 0;
        }

        return (int) (self::planConfig($plan)['price_fdj'] ?? 0);
    }

    /** Commandes du mois civil courant impliquant au moins un produit du vendeur (hors annulées). */
    public static function monthlyOrderCountForSeller(User $seller): int
    {
        if (! $seller->isVendeur()) {
            return 0;
        }

        $boutiqueId = $seller->boutique?->id;
        if (! $boutiqueId) {
            return 0;
        }

        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        if (! Schema::hasColumn('commandes', 'boutique_id')) {
            $myProductIds = Produit::where('vendeur_id', $seller->id)->pluck('id');
            if ($myProductIds->isEmpty()) {
                return 0;
            }

            return Commande::query()
                ->where('statut', '!=', 'annulee')
                ->whereBetween('date_commande', [$start, $end])
                ->whereIn('id', function ($sub) use ($myProductIds) {
                    $sub->select('commande_id')
                        ->from('commande_details')
                        ->whereIn('produit_id', $myProductIds)
                        ->distinct();
                })
                ->count();
        }

        return Commande::query()
            ->where('statut', '!=', 'annulee')
            ->where('boutique_id', $boutiqueId)
            ->whereBetween('date_commande', [$start, $end])
            ->count();
    }

    public static function createPaymentRequest(User $seller, string $plan, string $method, ?string $buyerReference = null): SellerSubscriptionPayment
    {
        $amount = self::priceForPlan($plan);
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Plan invalide pour paiement.');
        }

        return SellerSubscriptionPayment::create([
            'user_id' => $seller->id,
            'plan' => $plan,
            'amount_fdj' => $amount,
            'period_days' => (int) config('nexshop.seller_subscription.billing_period_days', 30),
            'payment_method' => $method,
            'status' => 'pending',
            'buyer_reference' => $buyerReference,
        ]);
    }

    public static function approvePayment(SellerSubscriptionPayment $payment, User $admin, ?string $notes = null): void
    {
        DB::transaction(function () use ($payment, $admin, $notes) {
            $payment->update([
                'status' => 'paid',
                'processed_by' => $admin->id,
                'processed_at' => now(),
                'admin_notes' => $notes,
            ]);

            $seller = $payment->user;
            $days = max(1, (int) $payment->period_days);
            $base = ($seller->abonnement_expires_at && $seller->abonnement_expires_at->isFuture())
                ? $seller->abonnement_expires_at
                : now();

            $seller->update([
                'abonnement_plan' => $payment->plan,
                'abonnement_started_at' => now(),
                'abonnement_expires_at' => $base->copy()->addDays($days),
            ]);

            $seller->notify(new SellerSubscriptionActivated($payment->plan, $seller->abonnement_expires_at));
        });
    }

    public static function rejectPayment(SellerSubscriptionPayment $payment, User $admin, ?string $notes = null): void
    {
        $payment->update([
            'status' => 'rejected',
            'processed_by' => $admin->id,
            'processed_at' => now(),
            'admin_notes' => $notes,
        ]);
    }
}
