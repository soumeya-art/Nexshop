<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('telephone_verifie')->default(false)->after('telephone');
            $table->boolean('email_verifie')->default(false)->after('telephone_verifie');
            $table->string('otp_code')->nullable()->after('email_verifie');
            $table->timestamp('otp_expire_at')->nullable()->after('otp_code');
            $table->enum('etape_inscription', ['compte', 'kyc', 'boutique', 'termine'])->default('compte')->after('otp_expire_at');
            $table->enum('statut_kyc', ['non_soumis', 'en_attente', 'valide', 'rejete'])->default('non_soumis')->after('etape_inscription');
            $table->text('motif_rejet_kyc')->nullable()->after('statut_kyc');
            $table->foreignId('valide_par')->nullable()->after('motif_rejet_kyc')->constrained('users');
            $table->timestamp('valide_at')->nullable()->after('valide_par');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('valide_par');
            $table->dropColumn([
                'telephone_verifie',
                'email_verifie',
                'otp_code',
                'otp_expire_at',
                'etape_inscription',
                'statut_kyc',
                'motif_rejet_kyc',
                'valide_at',
            ]);
        });
    }
};
