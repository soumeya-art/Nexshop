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
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('instagram_url')->nullable()->after('telephone_boutique');
            $table->string('snapchat_url')->nullable()->after('instagram_url');
            $table->string('tiktok_url')->nullable()->after('snapchat_url');
            $table->string('youtube_url')->nullable()->after('tiktok_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['instagram_url', 'snapchat_url', 'tiktok_url', 'youtube_url']);
        });
    }
};
