<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table = 'produits';

    protected $fillable = [
        'vendeur_id', 'categorie_id', 'nom', 'description',
        'prix', 'stock', 'image_principale', 'images_supplementaires', 'videos_supplementaires', 'statut',
    ];

    protected $casts = [
        'images_supplementaires' => 'array',
        'videos_supplementaires' => 'array',
        'prix' => 'decimal:2',
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

    /**
     * Produits au statut catalogue « actif » (colonne qualifiée pour éviter l’ambiguïté SQL avec une jointure users).
     */
    public function scopeActif(Builder $query): Builder
    {
        return $query->where($query->getModel()->getTable().'.statut', 'actif');
    }

    /**
     * Premium actifs d’abord, puis Pro, puis Free (visibilité catalogue).
     */
    public function scopeOrderBySellerSubscriptionPriority(Builder $query): Builder
    {
        $now = now()->toDateTimeString();

        return $query
            ->leftJoin('users as nx_sub_vendeurs', 'nx_sub_vendeurs.id', '=', 'produits.vendeur_id')
            ->orderByRaw(
                'CASE WHEN nx_sub_vendeurs.abonnement_plan = ? AND nx_sub_vendeurs.abonnement_expires_at > ? THEN 0 WHEN nx_sub_vendeurs.abonnement_plan = ? AND nx_sub_vendeurs.abonnement_expires_at > ? THEN 1 ELSE 2 END',
                ['premium', $now, 'pro', $now]
            )
            ->orderByDesc('produits.created_at')
            ->select('produits.*');
    }

    public function imageUrl(): string
    {
        $img = $this->image_principale ?? '';
        if (! $img) {
            return asset('images/shopping.png');
        }

        return str_starts_with($img, 'http') ? $img : asset($img);
    }
}
