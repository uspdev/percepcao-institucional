<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Grupo::create([
            'texto' => 'Percepção em cada disciplinas',
            'ativo' => 1,
            'repeticao' => 1,
            'modelo_repeticao' => 'disciplinas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'Auto avaliação',
            'ativo' => 1,
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'Infraestrutura, condições de ensino e da instituição',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'Coordenação',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
