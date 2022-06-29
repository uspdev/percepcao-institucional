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
            'texto' => 'PERCEPÇÃO DO ALUNO EM CADA DISCIPLINA',
            'ativo' => 1,
            'repeticao' => 1,
            'modelo_repeticao' => 'disciplinas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'AUTO AVALIAÇÃO DO ALUNO NA DISCIPLINA',
            'ativo' => 1,
            'repeticao' => 1,
            'modelo_repeticao' => 'disciplinas',
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'COMENTÁRIOS E SUGESTÕES DO ALUNO NA DISCIPLINA',
            'ativo' => 1,
            'repeticao' => 1,
            'modelo_repeticao' => 'disciplinas',
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\Grupo::create([
            'texto' => 'COMENTÁRIOS E SUGESTÕES GERAIS',
            'ativo' => 1,
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
            'texto' => 'PERCEPÇÃO DA COORDENAÇÃO',
            'ativo' => 1,
            'repeticao' => 1,
            'modelo_repeticao' => 'coordenadores',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
