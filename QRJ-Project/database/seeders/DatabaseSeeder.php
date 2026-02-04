<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['Correu' => 'test@example.com'],
            [
                'Nom' => 'Test User',
                'Contrasenya' => bcrypt('password'),
            ]
        );
    }
}
