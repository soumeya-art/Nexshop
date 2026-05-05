<?php

namespace App\Concerns;

use App\Models\Produit;
use App\Services\SellerSubscriptionService;

trait HasSellerSubscription
{
    public function hasActivePaidSubscription(): bool
    {
        if (! $this->isVendeur()) {
            return false;
        }

        if (! in_array($this->abonnement_plan, ['pro', 'premium'], true)) {
            return false;
        }

        return $this->abonnement_expires_at && $this->abonnement_expires_at->isFuture();
    }

    /** Abonnement payant actif expiré (renouvellement requis). */
    public function sellerPaidSubscriptionExpired(): bool
    {
        if (! $this->isVendeur()) {
            return false;
        }

        if (! in_array($this->abonnement_plan, ['pro', 'premium'], true)) {
            return false;
        }

        return ! $this->abonnement_expires_at || $this->abonnement_expires_at->isPast();
    }

    public function sellerMonthlyOrderCount(): int
    {
        return SellerSubscriptionService::monthlyOrderCountForSeller($this);
    }

    public function sellerFreeMonthlyLimit(): int
    {
        return (int) config('nexshop.seller_subscription.free_monthly_order_limit', 20);
    }

    public function sellerHitFreeMonthlyLimit(): bool
    {
        return $this->sellerMonthlyOrderCount() >= $this->sellerFreeMonthlyLimit();
    }

    /**
     * Compte bloqué pour nouvelles commandes / actions vendeur (chat, produits, etc.).
     */
    public function sellerSubscriptionLocked(): bool
    {
        if (! $this->isVendeur()) {
            return false;
        }

        if ($this->hasActivePaidSubscription()) {
            return false;
        }

        if ($this->sellerPaidSubscriptionExpired()) {
            return true;
        }

        return $this->sellerHitFreeMonthlyLimit();
    }

    public function sellerAcceptsNewOrders(): bool
    {
        return ! $this->sellerSubscriptionLocked();
    }

    public function sellerShowsVerifiedBadge(): bool
    {
        return $this->hasActivePaidSubscription();
    }

    public function sellerHasBasicStats(): bool
    {
        return $this->hasActivePaidSubscription();
    }

    public function sellerHasAdvancedStats(): bool
    {
        return $this->hasActivePaidSubscription() && $this->abonnement_plan === 'premium';
    }

    public function sellerHasMarketingTools(): bool
    {
        return $this->hasActivePaidSubscription() && $this->abonnement_plan === 'premium';
    }

    public function sellerSubscriptionDaysRemaining(): ?int
    {
        if (! $this->hasActivePaidSubscription() || ! $this->abonnement_expires_at) {
            return null;
        }

        return max(0, (int) today()->diffInDays($this->abonnement_expires_at->copy()->startOfDay()));
    }

    public function sellerSubscriptionExpiringWithinDays(int $days): bool
    {
        if (! $this->hasActivePaidSubscription() || ! $this->abonnement_expires_at) {
            return false;
        }

        return $this->abonnement_expires_at->lte(now()->addDays($days));
    }

    public function sellerIdsBlockingCheckoutFromItems(iterable $items): array
    {
        $blocked = [];
        foreach ($items as $item) {
            $produit = $item->produit ?? null;
            if (! $produit instanceof Produit) {
                continue;
            }
            $vendeur = $produit->vendeur;
            if ($vendeur && ! $vendeur->sellerAcceptsNewOrders()) {
                $blocked[$vendeur->id] = true;
            }
        }

        return array_keys($blocked);
    }
}
