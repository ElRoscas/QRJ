<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = 'admin@lasalle.cat';

        // Crear usuario admin
        DB::table('usuari')->insert([
            'Correu' => $adminEmail,
            'Nom' => 'Administrador',
            'Contrasenya' => Hash::make('admin123'),
            'Curs' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar permisos de admin
        DB::table('permissos')->insert([
            'ID_Usuari' => $adminEmail,
            'PermCode' => '11111',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Usuario admin creado:');
        $this->command->info('   Email: ' . $adminEmail);
        $this->command->info('   Password: admin123');
        $this->command->info('   Permisos: 11111 (admin completo)');
    }
}
