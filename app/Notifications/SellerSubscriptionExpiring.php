<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerSubscriptionExpiring extends Notification
{
    use Queueable;

    public function __construct(
        public int $daysLeft,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Abonnement bientôt terminé',
            'body' => 'Renouvelez sous '.$this->daysLeft.' jour(s) pour conserver le badge vérifié, les statistiques et les nouvelles commandes.',
            'days_left' => $this->daysLeft,
        ];
    }
}
