<?php

namespace App\Models;

use App\Concerns\HasSellerSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasSellerSubscription, Notifiable;

    protected $fillable = [
        'nom', 'email', 'avatar', 'telephone', 'password',
        'type_compte', 'vendeur_categorie_id', 'statut', 'adresse', 'ville', 'code_postal',
        'telephone_verifie', 'email_verifie', 'otp_code', 'otp_expire_at',
        'etape_inscription', 'statut_kyc', 'motif_rejet_kyc', 'valide_par', 'valide_at',
        'last_seen_at',
        'abonnement_plan',
        'abonnement_started_at',
        'abonnement_expires_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'telephone_verifie' => 'boolean',
            'email_verifie' => 'boolean',
            'otp_expire_at' => 'datetime',
            'valide_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'abonnement_started_at' => 'datetime',
            'abonnement_expires_at' => 'datetime',
        ];
    }

    // Relations
    public function vendeurProfil()
    {
        return $this->hasOne(Vendeur::class, 'user_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'vendeur_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function panier()
    {
        return $this->hasMany(Panier::class, 'client_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'client_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'client_id');
    }

    public function plateformeTemoignage()
    {
        return $this->hasOne(PlateformeTemoignage::class, 'user_id');
    }

    public function kyc()
    {
        return $this->hasOne(KycVendeur::class, 'user_id');
    }

    public function boutique()
    {
        return $this->hasOne(Boutique::class, 'user_id');
    }

    public function vendeurCategorie()
    {
        return $this->belongsTo(Categorie::class, 'vendeur_categorie_id');
    }

    public function followedSellers()
    {
        return $this->belongsToMany(User::class, 'seller_follows', 'buyer_id', 'seller_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'seller_follows', 'seller_id', 'buyer_id')->withTimestamps();
    }

    public function buyerNotifications()
    {
        return $this->hasMany(BuyerNotification::class, 'buyer_id');
    }

    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    public function isOnline(int $thresholdSeconds = 120): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subSeconds($thresholdSeconds));
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->type_compte === 'admin';
    }

    public function isVendeur(): bool
    {
        return $this->type_compte === 'vendeur';
    }

    public function isClient(): bool
    {
        return $this->type_compte === 'client';
    }

    public function estVendeurValide(): bool
    {
        return $this->type_compte === 'vendeur'
            && $this->statut_kyc === 'valide'
            && (bool) $this->boutique?->est_active;
    }

    /**
     * URL de destination après connexion (ou inscription) pour un vendeur.
     */
    public function vendeurPostLoginRoute(): string
    {
        if ($this->type_compte !== 'vendeur') {
            return route('home');
        }

        $etape = $this->etape_inscription ?? 'compte';

        if ($etape !== 'termine') {
            return match ($etape) {
                'kyc' => route('vendeur.inscription.kyc'),
                'boutique' => route('vendeur.inscription.boutique'),
                default => route('vendeur.inscription.index'),
            };
        }

        if ($this->statut_kyc !== 'valide') {
            return $this->statut_kyc === 'rejete'
                ? route('vendeur.inscription.kyc')
                : route('vendeur.attente');
        }

        return route('vendeur.home');
    }
}
