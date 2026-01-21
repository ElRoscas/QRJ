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
        Schema::create('esdeveniments', function (Blueprint $table) {
            $table->id();
            $table->string('ID_USER', 191); // Limitar longitud para FK
            $table->string('Tipus');
            $table->string('Ubicacio')->nullable();
            $table->date('Data_Esdeveniment');
            $table->time('Hora_Inici');
            $table->date('Data_Limit_Confirmacio')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('ID_USER')
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
        Schema::dropIfExists('esdeveniments');
    }
};
