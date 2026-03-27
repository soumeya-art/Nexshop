<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table    = 'commandes';
    protected $fillable = [
        'client_id', 'montant_total', 'statut', 'adresse_livraison',
        'mode_paiement', 'statut_paiement', 'date_commande', 'date_livraison',
    ];

    protected $casts = [
        'date_commande'  => 'datetime',
        'date_livraison' => 'datetime',
        'montant_total'  => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function details()
    {
        return $this->hasMany(CommandeDetail::class, 'commande_id');
    }
}
