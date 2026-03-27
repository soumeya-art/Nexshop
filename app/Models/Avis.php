<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table    = 'avis';
    protected $fillable = ['produit_id', 'client_id', 'note', 'commentaire', 'statut', 'date_avis'];

    protected $casts = ['date_avis' => 'datetime'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
