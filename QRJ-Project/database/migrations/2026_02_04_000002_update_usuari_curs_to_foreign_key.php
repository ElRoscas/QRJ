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
        Schema::table('usuari', function (Blueprint $table) {
            $table->unsignedBigInteger('curs_id')->nullable()->after('Contrasenya');

            $table->foreign('curs_id')
                ->references('id')
                ->on('cursos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuari', function (Blueprint $table) {
            $table->dropForeign(['curs_id']);
            $table->dropColumn('curs_id');
        });
    }
};
