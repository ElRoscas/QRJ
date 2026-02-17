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
        Schema::table('esdeveniments', function (Blueprint $table) {
            $table->integer('max_qrs_per_usuari')->default(1)->after('validar_capacitat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esdeveniments', function (Blueprint $table) {
            $table->dropColumn('max_qrs_per_usuari');
        });
    }
};
