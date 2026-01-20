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
        // No alterar tabla 'users' porque usamos 'usuari' personalizada
        // Si necesitas agregar columnas de dos factores a 'usuari', hazlo manualmente
        // Schema::table('users', function (Blueprint $table) {
        //     $table->text('two_factor_secret')->after('password')->nullable();
        //     $table->text('two_factor_recovery_codes')->after('two_factor_secret')->nullable();
        //     $table->timestamp('two_factor_confirmed_at')->after('two_factor_recovery_codes')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No alterar tabla 'users' porque usamos 'usuari' personalizada
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn([
        //         'two_factor_secret',
        //         'two_factor_recovery_codes',
        //         'two_factor_confirmed_at',
        //     ]);
        // });
    }
};
