<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycVendeur extends Model
{
    protected $table = 'kyc_vendeurs';

    protected $fillable = [
        'user_id',
        'type_piece',
        'piece_identite',
        'selfie_piece',
        'adresse',
    ];

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
