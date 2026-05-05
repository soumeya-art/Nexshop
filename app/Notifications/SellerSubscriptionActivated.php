<?php

namespace App\Notifications;

use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerSubscriptionActivated extends Notification
{
    use Queueable;

    public function __construct(
        public string $plan,
        public CarbonInterface $expiresAt,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Abonnement activé',
            'body' => 'Votre plan '.strtoupper($this->plan).' est actif jusqu’au '.$this->expiresAt->format('d/m/Y').'.',
            'plan' => $this->plan,
            'expires_at' => $this->expiresAt->toIso8601String(),
        ];
    }
}
