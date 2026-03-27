<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. USERS ──────────────────────────────────────────────
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email', 191)->unique();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->enum('type_compte', ['client', 'vendeur', 'admin'])->default('client');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'banni'])->default('actif');
            $table->rememberToken();
            $table->timestamps();
        });

        // ── 2. CLIENTS (classe fille de User) ────────────────────
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            // passerCommande, ajouterAuPanier, consulterCommandes, laisserAvis, ajouterFavori
            $table->timestamps();
        });

        // ── 3. VENDEURS (classe fille de User) ───────────────────
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nom_boutique')->nullable();
            $table->text('description_boutique')->nullable();
            // ajouterProduit, modifierProduit, supprimerProduit, gererStock, voirStatistiques, traiterCommande
            $table->timestamps();
        });

        // ── 4. ADMINISTRATEURS (classe fille de User) ────────────
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            // validerVendeur, modererAvis, gererUtilisateurs, voirAnalytics, gererCategories
            $table->timestamps();
        });

        // ── 5. CATEGORIES ─────────────────────────────────────────
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->string('icone')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // ── 6. PRODUITS ───────────────────────────────────────────
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('nom');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image_principale')->nullable();
            $table->json('images_supplementaires')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'rupture'])->default('actif');
            $table->timestamps();
        });

        // ── 7. COMMANDES ──────────────────────────────────────────
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->decimal('montant_total', 10, 2);
            $table->enum('statut', [
                'en_attente', 'confirmee', 'en_preparation',
                'en_livraison', 'livree', 'annulee'
            ])->default('en_attente');
            $table->string('adresse_livraison');
            $table->enum('mode_paiement', ['especes'])->default('especes');
            $table->enum('statut_paiement', ['en_attente', 'paye'])->default('en_attente');
            $table->timestamp('date_commande')->useCurrent();
            $table->timestamp('date_livraison')->nullable();
            $table->timestamps();
        });

        // ── 8. COMMANDE DETAILS ───────────────────────────────────
        Schema::create('commande_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();
        });

        // ── 9. LIVRAISONS ─────────────────────────────────────────
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_vendeur');
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_vendeur')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('date_livraison')->nullable();
            $table->enum('statut', ['preparee', 'expediee', 'en_route', 'livree', 'echec'])->default('preparee');
            $table->timestamps();
        });

        // ── 10. PANIERS ────────────────────────────────────────────
        Schema::create('paniers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite')->default(1);
            $table->timestamps();
        });
        Schema::table('paniers', function (Blueprint $table) {
            $table->unique(['client_id', 'produit_id']);
        });

        // ── 11. FAVORIS ────────────────────────────────────────────
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->timestamp('date_ajout')->useCurrent();
            $table->timestamps();
        });
        Schema::table('favoris', function (Blueprint $table) {
            $table->unique(['client_id', 'produit_id']);
        });

        // ── 12. AVIS ───────────────────────────────────────────────
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('note');
            $table->string('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'refuse'])->default('en_attente');
            $table->timestamp('date_avis')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
        Schema::dropIfExists('favoris');
        Schema::dropIfExists('paniers');
        Schema::dropIfExists('livraisons');
        Schema::dropIfExists('commande_details');
        Schema::dropIfExists('commandes');
        Schema::dropIfExists('produits');
        Schema::dropIfExists('administrateurs');
        Schema::dropIfExists('vendeurs');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};