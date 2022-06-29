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
        $textoApresentacao = 'O presente questionário será utilizado na EEL-USP para melhoria da qualidade de ensino. As identidades serão preservadas com total sigilo.';
        $textoFormularioAvaliacao = 'Responda com responsabilidade !';
        $questaoSettings = '{"grupos":{"1":{"id":1,"ordem":1,"texto":"Percep\u00e7\u00e3o em cada disciplinas","repeticao":1,"modelo_repeticao":"disciplinas","grupos":{"2":{"id":2,"ordem":0,"texto":"Auto avalia\u00e7\u00e3o","repeticao":0,"modelo_repeticao":null,"questoes":{"10":{"id":10,"campo":{"type":"radio","text":"Relacionamento com os alunos","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"22":{"id":22,"campo":{"type":"textarea","text":"Coment\u00e1rios e sugest\u00f5es","maxlength":500,"rows":3,"options":""}}}}},"questoes":{"1":{"id":1,"campo":{"options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"type":"radio","text":"Assiduidade\/Pontualidade","rules":"required|integer|min:1|max:5"}},"2":{"id":2,"campo":{"type":"radio","text":"Apresenta\u00e7\u00e3o\/Cumprimento do plano de ensino","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}},"3":{"id":3,"campo":{"type":"radio","text":"Conhecimento\/Atualiza\u00e7\u00e3o da mat\u00e9ria","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}]}}}}}}';
        $p = Percepcao::create([
            'dataDeAbertura' => now()->addDays(1)->format('d/m/Y H:i:s'),
            'dataDeFechamento' => now()->addDays(mt_rand(2, 10))->format('d/m/Y H:i:s'),
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
