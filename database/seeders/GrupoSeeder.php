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
            'texto' => 'Grupo disciplinas',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'Grupo auto avaliação',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
