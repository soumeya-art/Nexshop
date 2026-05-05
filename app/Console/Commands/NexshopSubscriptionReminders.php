<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SellerSubscriptionExpired;
use App\Notifications\SellerSubscriptionExpiring;
use Illuminate\Console\Command;

class NexshopSubscriptionReminders extends Command
{
    protected $signature = 'nexshop:subscription-reminders';

    protected $description = 'Notifications vendeurs : expiration imminente et abonnement expiré.';

    public function handle(): int
    {
        $expiring = User::query()
            ->where('type_compte', 'vendeur')
            ->whereIn('abonnement_plan', ['pro', 'premium'])
            ->whereNotNull('abonnement_expires_at')
            ->where('abonnement_expires_at', '>', now())
            ->where('abonnement_expires_at', '<=', now()->addDays(3))
            ->get();

        foreach ($expiring as $user) {
            $dup = $user->notifications()
                ->where('type', SellerSubscriptionExpiring::class)
                ->where('created_at', '>', now()->subDays(2))
                ->exists();
            if ($dup) {
                continue;
            }
            $days = max(1, (int) today()->diffInDays($user->abonnement_expires_at->copy()->startOfDay()));
            $user->notify(new SellerSubscriptionExpiring($days));
        }

        $expired = User::query()
            ->where('type_compte', 'vendeur')
            ->whereIn('abonnement_plan', ['pro', 'premium'])
            ->whereNotNull('abonnement_expires_at')
            ->where('abonnement_expires_at', '<', now())
            ->get();

        foreach ($expired as $user) {
            $dup = $user->notifications()
                ->where('type', SellerSubscriptionExpired::class)
                ->where('created_at', '>', $user->abonnement_expires_at)
                ->exists();
            if ($dup) {
                continue;
            }
            $user->notify(new SellerSubscriptionExpired);
        }

        $this->info(sprintf('Rappels envoyés : %d expiration(s) proche(s), %d expiré(s).', $expiring->count(), $expired->count()));

        return self::SUCCESS;
    }
}
