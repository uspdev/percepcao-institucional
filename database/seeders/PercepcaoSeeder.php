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
        $textoApresentacao = 'O presente questionário será utilizado na EESC-USP para melhoria da qualidade de ensino. As identidades serão preservadas com total sigilo.';
        $textoFormularioAvaliacao = 'Responda com responsabilidade !';
        $questaoSettings = '{"grupos":{"1":{"id":1,"ordem":1,"texto":"Disciplinas","repeticao":0,"modelo_repeticao":null,"grupos":{"2":{"id":2,"ordem":0,"texto":"Auto avalia\u00e7\u00e3o","repeticao":0,"modelo_repeticao":null,"questoes":{"10":{"id":10,"campo":{"type":"radio","text":"Relacionamento com os alunos","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}}}}},"questoes":{"2":{"id":2,"campo":{"options":{"1":{"key":"1","value":"Ruim"},"2":{"key":"2","value":"Regular"},"3":{"key":"3","value":"Bom"}},"type":"radio","text":"xxx Apresenta\u00e7\u00e3o\/Cumprimento do plano de ensino"}},"3":{"id":3,"campo":{"type":"radio","text":"Conhecimento\/Atualiza\u00e7\u00e3o da mat\u00e9ria","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"4":{"id":4,"campo":{"type":"radio","text":"Utilizacao da bibliografia b\u00e1sica na disciplina","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"5":{"id":5,"campo":{"type":"radio","text":"Clareza na exposi\u00e7\u00e3o dos conte\u00fados","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"6":{"id":6,"campo":{"type":"radio","text":"Relacionamento entre aspectos te\u00f3ricos e pr\u00e1ticos da disciplina","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"7":{"id":7,"campo":{"type":"radio","text":"Did\u00e1tica (dinamismo, clareza e organiza\u00e7\u00e3o na exposi\u00e7\u00e3o de temas) nas aulas ministradas","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"8":{"id":8,"campo":{"type":"radio","text":"Coer\u00eancia entre conte\u00fado ministrado e avalia\u00e7\u00f5es aplicadas","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"9":{"id":9,"campo":{"type":"radio","text":"Interesse em esclarecer as d\u00favidas dos alunos","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"10":{"id":10,"campo":{"type":"radio","text":"Relacionamento com os alunos","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"21":{"id":21,"campo":{"type":"radio","text":"Encaminhamento\/Solu\u00e7\u00e3o da Comiss\u00e3o","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"22":{"id":22,"campo":{"type":"textarea","text":"Texto livre","rows":"4","options":[""]}}}}}}';
        $p = Percepcao::create([
            'dataDeAbertura' => now()->format('d/m/Y H:i:s'),
            'dataDeFechamento' => now()->addDays(mt_rand(1, 10))->format('d/m/Y H:i:s'),
            'ano' => date('Y'),
            'semestre' => 1,
            'totalDeAlunosMatriculados' => mt_rand(100, 1000),
            'questao_settings' => $questaoSettings,
            'settings' => [
                'textoFormularioAvaliacao' => $textoFormularioAvaliacao,
                'textoApresentacao' => $textoApresentacao
            ]
        ]);

        // $grupo = Grupo::find(1);
        // $p->grupos()->attach($grupo, ['ordem' => 0]);
    }
}
