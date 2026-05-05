<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerNotification extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'produit_id',
        'titre',
        'message',
        'lu',
        'lu_at',
    ];

    protected function casts(): array
    {
        return [
            'lu' => 'boolean',
            'lu_at' => 'datetime',
        ];
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
