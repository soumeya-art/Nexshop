<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table    = 'produits';
    protected $fillable = [
        'vendeur_id', 'categorie_id', 'nom', 'description',
        'prix', 'stock', 'image_principale', 'images_supplementaires', 'statut',
    ];

    protected $casts = [
        'images_supplementaires' => 'array',
        'prix'                   => 'decimal:2',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'produit_id');
    }

    public function noteMoyenne(): float
    {
        return $this->avis()->where('statut', 'approuve')->avg('note') ?? 0;
    }

    public function imageUrl(): string
    {
        $img = $this->image_principale ?? '';
        if (!$img) return asset('images/shopping.png');
        return str_starts_with($img, 'http') ? $img : asset($img);
    }
}
