<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $table    = 'paniers';
    protected $fillable = ['client_id', 'produit_id', 'quantite'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
