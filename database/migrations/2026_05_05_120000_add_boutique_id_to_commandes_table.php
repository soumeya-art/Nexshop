<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (! Schema::hasColumn('commandes', 'boutique_id')) {
                $table->foreignId('boutique_id')
                    ->nullable()
                    ->after('client_id')
                    ->constrained('boutiques')
                    ->nullOnDelete();
            }
        });

        DB::table('commandes')
            ->whereNull('boutique_id')
            ->orderBy('id')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $c) {
                    $detail = DB::table('commande_details')
                        ->where('commande_id', $c->id)
                        ->orderBy('id')
                        ->first();
                    if (! $detail) {
                        continue;
                    }
                    $produit = DB::table('produits')->where('id', $detail->produit_id)->first();
                    if (! $produit) {
                        continue;
                    }
                    $boutiqueId = DB::table('boutiques')->where('user_id', $produit->vendeur_id)->value('id');
                    if ($boutiqueId) {
                        DB::table('commandes')->where('id', $c->id)->update(['boutique_id' => $boutiqueId]);
                    }
                }
            });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'boutique_id')) {
                $table->dropForeign(['boutique_id']);
                $table->dropColumn('boutique_id');
            }
        });
    }
};
