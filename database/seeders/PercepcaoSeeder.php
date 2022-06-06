<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Percepcao;
use Illuminate\Database\Seeder;

class PercepcaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = Percepcao::create([
            'dataDeAbertura' => now()->format('d/m/Y H:i:s'),
            'dataDeFechamento' => now()->addDays(mt_rand(1, 10))->format('d/m/Y H:i:s'),
            'ano' => date('Y'),
            'semestre' => 2,
            'totalDeAlunosMatriculados' => mt_rand(100, 1000),
        ]);

        // $grupo = Grupo::find(1);
        // $p->grupos()->attach($grupo, ['ordem' => 0]);
    }
}
