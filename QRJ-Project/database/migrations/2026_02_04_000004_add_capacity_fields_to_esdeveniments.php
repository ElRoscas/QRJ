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
            $table->integer('capacitat_max_acompanyants')->default(2)->after('Nº_Invitats');
            $table->boolean('validar_capacitat')->default(true)->after('capacitat_max_acompanyants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esdeveniments', function (Blueprint $table) {
            $table->dropColumn(['capacitat_max_acompanyants', 'validar_capacitat']);
        });
    }
};
