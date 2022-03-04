<?php

namespace Database\Seeders;

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
        \App\Models\Percepcao::create([
            'dataDeAbertura' => now()->format('d/m/Y H:i:s'),
            'dataDeFechamento' => now()->addDays(3)->format('d/m/Y H:i:s'),
            'ano' => date('Y'),
            'semestre' => 2,
            'totalDeAlunosMatriculados' => mt_rand(100,1000),
        ]);
    }
}
