<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Journal des sources Pro servies à la CLI.
     *
     * Sert d'abord à enquêter : un jeton partagé publiquement se voit ici
     * (mêmes fichiers tirés depuis des dizaines d'adresses). Purgé après
     * 90 jours, voir App\Models\RegistryDownload.
     */
    public function up(): void
    {
        Schema::create('registry_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_token_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item', 80);
            // Par où la source est sortie : la CLI (`flexi:add`) ou le serveur MCP.
            $table->string('channel', 8)->default('cli');
            $table->string('ip', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['api_token_id', 'created_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registry_downloads');
    }
};
