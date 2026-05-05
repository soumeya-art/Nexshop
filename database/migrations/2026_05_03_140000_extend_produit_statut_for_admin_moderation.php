<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE produits MODIFY COLUMN statut VARCHAR(40) NOT NULL DEFAULT 'actif'");
        }
    }

    public function down(): void
    {
        // Rollback peut échouer si des statuts Hors ENUM existent encore — laissé vide pour éviter des pertes de données.
    }
};
