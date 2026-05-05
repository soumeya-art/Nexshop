<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerSubscriptionOrderLimitReached extends Notification
{
    use Queueable;

    public function __construct(
        public int $limit,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Limite du plan Free atteinte',
            'body' => 'Vous avez atteint '.$this->limit.' commandes ce mois-ci. Passez au Pro ou Premium pour continuer à vendre.',
            'limit' => $this->limit,
        ];
    }
}
