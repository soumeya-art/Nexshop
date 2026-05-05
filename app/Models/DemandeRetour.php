<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeRetour extends Model
{
    protected $table = 'demande_retours';

    protected $fillable = [
        'commande_id', 'client_id', 'produit_id', 'quantite',
        'motif', 'description', 'statut', 'note_admin',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function vendeur()
    {
        return $this->produit?->vendeur();
    }
}
