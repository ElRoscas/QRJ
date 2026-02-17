<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            // ESO
            ['nombre' => '1r ESO', 'nivel' => 'ESO', 'orden' => 1, 'activo' => true],
            ['nombre' => '2n ESO', 'nivel' => 'ESO', 'orden' => 2, 'activo' => true],
            ['nombre' => '3r ESO', 'nivel' => 'ESO', 'orden' => 3, 'activo' => true],
            ['nombre' => '4t ESO', 'nivel' => 'ESO', 'orden' => 4, 'activo' => true],

            // Batxillerat
            ['nombre' => '1r Batxillerat', 'nivel' => 'Batxillerat', 'orden' => 5, 'activo' => true],
            ['nombre' => '2n Batxillerat', 'nivel' => 'Batxillerat', 'orden' => 6, 'activo' => true],

            // Cicles Formatius Grau Mitjà
            ['nombre' => '1r CFGM', 'nivel' => 'CFGM', 'orden' => 7, 'activo' => true],
            ['nombre' => '2n CFGM', 'nivel' => 'CFGM', 'orden' => 8, 'activo' => true],

            // Cicles Formatius Grau Superior
            ['nombre' => '1r CFGS', 'nivel' => 'CFGS', 'orden' => 9, 'activo' => true],
            ['nombre' => '2n CFGS', 'nivel' => 'CFGS', 'orden' => 10, 'activo' => true],

            // Personal
            ['nombre' => 'Professorat', 'nivel' => 'Personal', 'orden' => 11, 'activo' => true],
            ['nombre' => 'Administració', 'nivel' => 'Personal', 'orden' => 12, 'activo' => true],
        ];

        foreach ($cursos as $curs) {
            DB::table('cursos')->insert(array_merge($curs, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
