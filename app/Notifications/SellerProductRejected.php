<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerProductRejected extends Notification
{
    use Queueable;

    public function __construct(
        public Produit $product,
        public ?string $motif = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $motifText = $this->motif ? ' Motif : '.$this->motif : '';

        return [
            'produit_id' => $this->product->id,
            'nom' => $this->product->nom,
            'preview' => 'Votre produit « '.$this->product->nom.' » n’a pas été publié.'.$motifText,
            'motif' => $this->motif,
        ];
    }
}
