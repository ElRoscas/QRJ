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
        Schema::create('permissos', function (Blueprint $table) {
            $table->id('ID_Permissos');
            $table->string('ID_Usuari', 191);
            $table->string('PermCode', 5); // 00000-11111 (5 caracteres)
            $table->timestamps();

            // Foreign key
            $table->foreign('ID_Usuari')
                ->references('Correu')
                ->on('usuari')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissos');
    }
};
