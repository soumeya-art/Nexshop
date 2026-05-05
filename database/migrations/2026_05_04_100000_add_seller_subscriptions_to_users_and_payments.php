<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('abonnement_plan', 20)->default('free')->after('last_seen_at');
            $table->timestamp('abonnement_started_at')->nullable()->after('abonnement_plan');
            $table->timestamp('abonnement_expires_at')->nullable()->after('abonnement_started_at');
        });

        Schema::create('seller_subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan', 20);
            $table->unsignedInteger('amount_fdj');
            $table->unsignedSmallInteger('period_days')->default(30);
            $table->string('payment_method', 32);
            $table->string('status', 20)->default('pending');
            $table->string('buyer_reference', 191)->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_subscription_payments');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['abonnement_plan', 'abonnement_started_at', 'abonnement_expires_at']);
        });
    }
};
