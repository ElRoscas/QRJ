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
            $table->string('qr_code', 100)->unique()->nullable()->after('Curs');
            $table->boolean('has_qr')->default(false)->after('qr_code');
            $table->enum('qr_status', ['fora', 'dins'])->default('fora')->after('has_qr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuari', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'has_qr', 'qr_status']);
        });
    }
};
