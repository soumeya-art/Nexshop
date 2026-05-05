<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerSubscriptionExpired extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Abonnement expiré',
            'body' => 'Votre formule payante a expiré. Renouvelez pour débloquer les commandes, la messagerie et la gestion catalogue.',
        ];
    }
}
