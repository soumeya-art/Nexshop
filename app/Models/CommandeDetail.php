<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeDetail extends Model
{
    protected $table    = 'commande_details';
    protected $fillable = ['commande_id', 'produit_id', 'quantite', 'prix_unitaire'];

    protected $casts = ['prix_unitaire' => 'decimal:2'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
