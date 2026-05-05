<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (! Schema::hasColumn('commandes', 'zone_livraison')) {
                $table->string('zone_livraison')->nullable()->after('adresse_livraison');
            }
            if (! Schema::hasColumn('commandes', 'frais_livraison')) {
                $table->decimal('frais_livraison', 10, 2)->default(0)->after('montant_total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'zone_livraison')) {
                $table->dropColumn('zone_livraison');
            }
            if (Schema::hasColumn('commandes', 'frais_livraison')) {
                $table->dropColumn('frais_livraison');
            }
        });
    }
};
