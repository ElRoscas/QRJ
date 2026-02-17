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
        Schema::create('esdeveniment_assistents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('esdeveniment_id');
            $table->string('usuari_correu', 191);
            $table->integer('num_acompanyants_permesos')->default(2);
            $table->integer('num_acompanyants_confirmats')->default(0);
            $table->boolean('confirmat')->default(false);
            $table->timestamp('data_confirmacio')->nullable();
            $table->timestamps();

            $table->foreign('esdeveniment_id')
                ->references('id')
                ->on('esdeveniments')
                ->onDelete('cascade');

            $table->foreign('usuari_correu')
                ->references('Correu')
                ->on('usuari')
                ->onDelete('cascade');

            $table->unique(['esdeveniment_id', 'usuari_correu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esdeveniment_assistents');
    }
};
