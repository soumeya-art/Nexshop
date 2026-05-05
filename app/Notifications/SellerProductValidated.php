<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerProductValidated extends Notification
{
    use Queueable;

    public function __construct(
        public Produit $product
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'produit_id' => $this->product->id,
            'nom' => $this->product->nom,
            'preview' => 'Votre produit « '.$this->product->nom.' » a été validé et est désormais visible par les acheteurs.',
        ];
    }
}
