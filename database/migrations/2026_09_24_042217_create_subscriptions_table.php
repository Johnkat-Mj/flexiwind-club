<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            // Clé de plan validée contre config('plans') : jamais une valeur
            // libre venue du client.
            $table->string('plan_key');
            $table->unsignedTinyInteger('seats')->default(1);
            $table->string('status')->default('pending'); // pending|active|expired|cancelled

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable(); // null = lifetime

            // Traçabilité du paiement. Le montant vient du serveur, pas du form.
            $table->unsignedInteger('amount_cents')->default(0);
            $table->string('currency', 3)->default('EUR');
            $table->string('provider')->default('simulated');
            $table->string('provider_reference')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['owner_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
