<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('usuari_correu', 191); // Limit to 191 chars for index compatibility
            $table->foreignId('esdeveniment_id')->constrained('esdeveniments')->onDelete('cascade');
            $table->string('qr_code', 191)->unique(); // Limit to 191 chars for index compatibility
            $table->string('qr_code_path')->nullable();
            $table->boolean('qr_sent')->default(false);
            $table->timestamps();

            // Foreign key to usuari table
            $table->foreign('usuari_correu')
                ->references('Correu')
                ->on('usuari')
                ->onDelete('cascade');

            // Index for faster queries
            $table->index(['usuari_correu', 'esdeveniment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
