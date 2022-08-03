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
        // Modelo EEL
        $textoApresentacao = 'O presente questionário será utilizado na EEL-USP para melhoria da qualidade de ensino. As identidades serão preservadas com total sigilo.';
        $textoFormularioAvaliacao = 'Responda com responsabilidade !';
        $questaoSettings = '{"grupos":{"1":{"id":1,"ordem":1,"texto":"PERCEP\u00c7\u00c3O DO ALUNO EM CADA DISCIPLINA","repeticao":1,"modelo_repeticao":"disciplinas","grupos":{"2":{"id":2,"ordem":0,"texto":"AUTO AVALIA\u00c7\u00c3O DO ALUNO NA DISCIPLINA","repeticao":1,"modelo_repeticao":"disciplinas","questoes":{"12":{"id":12,"campo":{"type":"radio","text":"Participa\u00e7\u00e3o nas aulas:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"13":{"id":13,"campo":{"type":"radio","text":"Relacionamento com os colegas, professores e pessoal administrativo:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}}}},"3":{"id":3,"ordem":1,"texto":"COMENT\u00c1RIOS E SUGEST\u00d5ES DO ALUNO NA DISCIPLINA","repeticao":1,"modelo_repeticao":"disciplinas","questoes":{"43":{"id":43,"campo":{"type":"textarea","text":"Coment\u00e1rios e sugest\u00f5es do aluno na disciplina","maxlength":400,"rows":3,"options":"","rules":"max:400"}}}}},"questoes":{"1":{"id":1,"campo":{"type":"radio","text":"Assiduidade\/Pontualidade:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"2":{"id":2,"campo":{"type":"radio","text":"Apresenta\u00e7\u00e3o\/Cumprimento do plano de ensino:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"3":{"id":3,"campo":{"type":"radio","text":"Conhecimento\/Atualiza\u00e7\u00e3o da mat\u00e9ria:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}}}},"6":{"id":6,"ordem":2,"texto":"PERCEP\u00c7\u00c3O DA COORDENA\u00c7\u00c3O","repeticao":1,"modelo_repeticao":"coordenadores","questoes":{"23":{"id":23,"campo":{"type":"radio","text":"Disponibilidade\/Hor\u00e1rios do coordenador:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"24":{"id":24,"campo":{"type":"radio","text":"Qualidade no atendimento do Coordenador:","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}}}}}}';
        $p = Percepcao::create([
            'dataDeAbertura' => '6/6/2022 0:00:00',
            'dataDeFechamento' => '10/6/2022 23:59:59',
            'ano' => date('Y'),
            'semestre' => 1,
            'questao_settings' => $questaoSettings,
            'settings' => [
                'textoFormularioAvaliacao' => $textoFormularioAvaliacao,
                'textoApresentacao' => $textoApresentacao,
                'nome' => 'Modelo da EEL',
                'totalDeAlunosMatriculados' => mt_rand(100, 1000),
            ]
        ]);

        // Modelo EESC
        $textoApresentacao = 'Este questionário será utilizado na EESC-USP para identificar problemas, apreciar e divulgar as boas práticas dentro dos aspectos avaliados, bem como corrigir ou indicar caminhos para os problemas levantados. Caracteriza-se como um importante instrumento de melhoria da qualidade do ensino à medida em que permite a identificação de problemas e de boas práticas.  As respostas individuais serão preservadas com total sigilo.';
        $textoFormularioAvaliacao = 'Para cada disciplina cursada será apresentado um questionário com 19 questões sobre o professor, a disciplina e sua autoavaliação. Caso a disciplina tenha mais de um professor, terá questionários distintos para a mesma disciplina separados por professor. Todas as respostas são obrigatórias. Depois de submeter as respostas elas não poderão ser alteradas.';
        $questaoSettings = '
            {"grupos":{"7":{"id":7,"ordem":1,"texto":"PERCEP\u00c7\u00c3O EM CADA DISCIPLINA","repeticao":1,"modelo_repeticao":"disciplinas","grupos":{"8":{"id":8,"ordem":0,"texto":"Professor","repeticao":1,"modelo_repeticao":"disciplinas","questoes":{"26":{"id":26,"campo":{"type":"radio","text":"Como voc\u00ea avalia a pontualidade e assiduidade do professor?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"27":{"id":27,"campo":{"type":"radio","text":"O professor apresentou um plano de ensino (cronograma\/m\u00e9todo avaliativo)?","options":[{"key":"1","value":"Sim"},{"key":"2","value":"N\u00e3o"}],"rules":"required|integer|min:1|max:2"}},"28":{"id":28,"campo":{"type":"radio","text":"O plano de ensino foi cumprido?","options":[{"key":"1","value":"N\u00e3o Cumprido"},{"key":"2","value":"Regular"},{"key":"3","value":"Cumprido integralmente"}],"rules":"required|integer|min:1|max:3"}},"29":{"id":29,"campo":{"type":"radio","text":"Como avalia o dom\u00ednio (t\u00e9cnico\/te\u00f3rico) do professor na disciplina?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"30":{"id":30,"campo":{"type":"radio","text":"Os recursos disponibilizados (material de apoio, videoaulas, listas de exerc\u00edcios, exemplos em aula, v\u00eddeos, imagens, \u00e1udios, softwares, etc) s\u00e3o suficientes e adequados para o aprendizado e a realiza\u00e7\u00e3o das avalia\u00e7\u00f5es?","options":[{"key":"1","value":"Muito pouco"},{"key":"2","value":"Pouco"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"31":{"id":31,"campo":{"type":"radio","text":"Como voc\u00ea avalia a did\u00e1tica (dinamismo, clareza e organiza\u00e7\u00e3o na exposi\u00e7\u00e3o de temas) nas aulas ministradas?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"32":{"id":32,"campo":{"type":"radio","text":"Como voc\u00ea avalia a coer\u00eancia entre conte\u00fado ministrado e as avalia\u00e7\u00f5es aplicadas?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"33":{"id":33,"campo":{"type":"radio","text":"Como avalia a abertura e disponibilidade do(a) docente a respeito de d\u00favidas de conte\u00fado e da programa\u00e7\u00e3o da disciplina?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"34":{"id":34,"campo":{"type":"radio","text":"Como avalia a preocupa\u00e7\u00e3o do(a) docente com o processo de aprendizado do conte\u00fado?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"45":{"id":45,"campo":{"type":"textarea","text":"Espa\u00e7o para coment\u00e1rios sobre o(a) professor(a)","maxlength":400,"rows":3,"options":"","rules":"max:400"}}}},"9":{"id":9,"ordem":1,"texto":"Disciplina","repeticao":1,"modelo_repeticao":"disciplinas","questoes":{"35":{"id":35,"campo":{"type":"radio","text":"Qu\u00e3o atualizado \u00e9 o conte\u00fado da  disciplina?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"36":{"id":36,"campo":{"type":"radio","text":"A bibliografia b\u00e1sica contempla o conte\u00fado principal abordado na disciplina?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"37":{"id":37,"campo":{"type":"radio","text":"Como voc\u00ea avalia a conex\u00e3o entre aspectos te\u00f3ricos e pr\u00e1ticos da disciplina?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"38":{"id":38,"campo":{"type":"radio","text":"Voc\u00ea tem entendimento do papel formativo da disciplina na estrutura do seu curso?","options":[{"key":"1","value":"Pouco"},{"key":"2","value":"Parcial"},{"key":"3","value":"Muito"}],"rules":"required|integer|min:1|max:3"}},"39":{"id":39,"campo":{"type":"radio","text":"Como voc\u00ea avalia o  tempo requerido para cumprir as atividades relacionadas \u00e0 disciplina com rela\u00e7\u00e3o ao seu n\u00famero de cr\u00e9ditos?","options":[{"key":"1","value":"Incoerente"},{"key":"2","value":"Parcialmente coerente"},{"key":"3","value":"Coerente"}],"rules":"required|integer|min:1|max:3"}},"46":{"id":46,"campo":{"type":"textarea","text":"Espa\u00e7o para coment\u00e1rios sobre a disciplina","maxlength":400,"rows":3,"options":"","rules":"max:400"}}}},"10":{"id":10,"ordem":2,"texto":"Auto avalia\u00e7\u00e3o do aluno","repeticao":1,"modelo_repeticao":"disciplinas","questoes":{"40":{"id":40,"campo":{"type":"radio","text":"Como voc\u00ea avalia a sua pontualidade e assiduidade?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"41":{"id":41,"campo":{"type":"radio","text":"Como avalia a sua participa\u00e7\u00e3o nas aulas (perguntar, realizar as atividades propostas durante a aula)?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"42":{"id":42,"campo":{"type":"radio","text":"Qu\u00e3o bem voc\u00ea cumpriu as atividades recomendadas?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"43":{"id":43,"campo":{"type":"radio","text":"Como avalia a sua colabora\u00e7\u00e3o com os colegas no desenvolvimento de atividades realizadas durante as aulas (empatia com os colegas, tirar d\u00favidas, auxiliar em atividades)?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"44":{"id":44,"campo":{"type":"radio","text":"Como foi o seu relacionamento com os colegas e professores?","options":[{"key":"1","value":"Muito ruim"},{"key":"2","value":"Ruim"},{"key":"3","value":"Regular"},{"key":"4","value":"Bom"},{"key":"5","value":"Muito bom"}],"rules":"required|integer|min:1|max:5"}},"47":{"id":47,"campo":{"type":"textarea","text":"Espa\u00e7o para coment\u00e1rios sobre a sua autoavalia\u00e7\u00e3o","maxlength":400,"rows":3,"options":"","rules":"max:400"}}}}}},"4":{"id":4,"ordem":2,"texto":"COMENT\u00c1RIOS E SUGEST\u00d5ES GERAIS","repeticao":0,"modelo_repeticao":null,"questoes":{"48":{"id":48,"campo":{"type":"textarea","text":"Coment\u00e1rios e sugest\u00f5es gerais (Neste espa\u00e7o pode incluir coment\u00e1rios acerca da infraestrutura da EESC. Por exemplo, sobre as instala\u00e7\u00f5es prediais, laboratoriais, livros na biblioteca, apoio t\u00e9cnico.)","maxlength":400,"rows":3,"options":"","rules":"max:400"}}}}}}
        ';
        $p = Percepcao::create([
            'dataDeAbertura' => '6/6/2022 0:00:00',
            'dataDeFechamento' => '10/6/2022 23:59:59',
            'ano' => 2022,
            'semestre' => 1,
            'questao_settings' => $questaoSettings,
            'settings' => [
                'textoFormularioAvaliacao' => $textoFormularioAvaliacao,
                'textoApresentacao' => $textoApresentacao,
                'nome' => 'Modelo da EESC',
                'totalDeAlunosMatriculados' => mt_rand(100, 1000),
                'membrosEspeciais' => [1575309, 12345],
            ]
        ]);
    }
}
