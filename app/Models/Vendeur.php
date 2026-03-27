<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
    protected $table    = 'vendeurs';
    protected $fillable = ['user_id', 'nom_boutique', 'description_boutique'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
