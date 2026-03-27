<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'telephone', 'password',
        'type_compte', 'statut', 'adresse', 'ville', 'code_postal',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relations
    public function vendeurProfil()  { return $this->hasOne(Vendeur::class, 'user_id'); }
    public function produits()       { return $this->hasMany(Produit::class, 'vendeur_id'); }
    public function commandes()      { return $this->hasMany(Commande::class, 'client_id'); }
    public function panier()         { return $this->hasMany(Panier::class, 'client_id'); }
    public function favoris()        { return $this->hasMany(Favori::class, 'client_id'); }
    public function avis()           { return $this->hasMany(Avis::class, 'client_id'); }

    // Role helpers
    public function isAdmin(): bool   { return $this->type_compte === 'admin'; }
    public function isVendeur(): bool { return $this->type_compte === 'vendeur'; }
    public function isClient(): bool  { return $this->type_compte === 'client'; }
}
