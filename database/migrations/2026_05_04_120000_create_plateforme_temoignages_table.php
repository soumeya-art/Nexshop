<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plateforme_temoignages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('note');
            $table->text('commentaire');
            $table->string('statut', 20)->default('approuve');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plateforme_temoignages');
    }
};
