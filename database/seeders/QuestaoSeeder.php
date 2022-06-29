<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            ["key" => "1", "value" => "Muito ruim"],
            ["key" => "2", "value" => "Ruim"],
            ["key" => "3", "value" => "Regular"],
            ["key" => "4", "value" => "Bom"],
            ["key" => "5", "value" => "Muito bom"],
        ];

        $optionsSImNao = [
            ["key" => "1", "value" => "Sim"],
            ["key" => "2", "value" => "Não"],
        ];

        $optionsCumprimento = [
            ["key" => "1", "value" => "Não cumprido"],
            ["key" => "2", "value" => "Cumprido integralmente"],
        ];

        $textos = [
            // EEL
            'Assiduidade/Pontualidade',
            'Apresentação/Cumprimento do plano de ensino',
            'Conhecimento/Atualização da matéria',
            'Utilizacao da bibliografia básica na disciplina',
            'Clareza na exposição dos conteúdos',
            'Relacionamento entre aspectos teóricos e práticos da disciplina',
            'Didática (dinamismo, clareza e organização na exposição de temas) nas aulas ministradas',
            'Coerência entre conteúdo ministrado e avaliações aplicadas',
            'Interesse em esclarecer as dúvidas dos alunos',
            'Relacionamento com os alunos',

            'Compromisso',
            'Participação nas aulas',
            'Relacionamento com os colegas, professores e pessoal administrativo',
            'Cumprimento das atividades recomendadas',

            'Iluminação, circulação de ar e acústica das salas de aula',
            'Espaço físico/número de alunos das salas de aula',
            'Acervo da Biblioteca (qualidade e quantidade de livros disponíveis para estudo e empréstimo)',
            'Disponibilidade de equipamento de informática',
            'Espaço da Biblioteca destinado ao estudo individual e salas para estudo coletivo',
            'Laboratórios utilizados para complementar os ensinos teóricos, apresentados em sala de aula',
            'Limpeza e higiene dos ambientes: banheiros, salas de aula, biblioteca e áreas externas',
            'Restaurante universitário',

            'Disponibilidade/Horários do coordenador',
            'Qualidade no atendimento do Coordenador',
            'Encaminhamento/Solução da Comissão',
        ];

        foreach ($textos as $texto) {
            \App\Models\Questao::create([
                'campo' => [
                    'type' => 'radio',
                    'text' => $texto,
                    'options' => $options,
                    'rules' => 'required|integer|min:1|max:5',
                ],
                'ativo' => 1,
            ]);
        }

        $campos = [
            [
                'type' => 'radio',
                'text' => 'Como você avalia a pontualidade e assiduidade do professor?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'O professor apresentou um plano de ensino?',
                'options' => [["key" => "1", "value" => "Sim"], ["key" => "2", "value" => "Não"]],
                'rules' => 'required|integer|min:1|max:2',
            ],
            [
                'type' => 'radio',
                'text' => 'O plano de ensino foi cumprido?',
                'options' => [["key" => "1", "value" => "Sim"], ["key" => "2", "value" => "Não"]],
                'rules' => 'required|integer|min:1|max:2',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia o domínio do professor na disciplina?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Os recursos disponibilizados (PDF\'s, vídeo aulas, listas de exercícios, exemplos em aula, vídeos, imagens, áudios, softwares, etc) são suficientes e adequados para o aprendizado e a realização das avaliações?',
                'options' => $options, // precisa ajustar
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia a didática (dinamismo, clareza e organização na exposição de temas) nas aulas ministradas?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como você avalia a coerência entre conteúdo ministrado e avaliações aplicadas?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia a abertura e disponibilidade do(a) docente a respeito de dúvidas de conteúdo e da programação da disciplina?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia a preocupação do(a) docente com o processo de aprendizado do conteúdo?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],

            [
                'type' => 'radio',
                'text' => 'Quão atualizada é o conteúdo da  disciplina?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'A bibliografia básica contempla o conteúdo principal abordado na disciplina?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como você avalia a conexão entre aspectos teóricos e práticos da disciplina?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Você  tem entendimento do papel formativo da disciplina na estrutura do seu curso?',
                'options' => [["key" => "1", "value" => "Pouco"], ["key" => "2", "value" => "Parcial"], ["key" => "3", "value" => "Muito"]],
                'rules' => 'required|integer|min:1|max:5',
            ],

            // aluno na disciplina
            [
                'type' => 'radio',
                'text' => 'Como você avalia a sua pontualidade e assiduidade? ',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia a sua participação nas aulas (perguntar, realizar as atividades propostas durante a aula)?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Quão bem você cumpriu as atividades recomendadas?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
            [
                'type' => 'radio',
                'text' => 'Como avalia a sua colaboração com colegas no desenvolvimento de atividades propostas durante as aulas (empatia com os colegas)?',
                'options' => $options,
                'rules' => 'required|integer|min:1|max:5',
            ],
        ];

        foreach ($campos as $campo) {
            \App\Models\Questao::create([
                'campo' => $campo,
                'ativo' => 1,
            ]);
        }

        \App\Models\Questao::create([
            'campo' => [
                'type' => 'textarea',
                'text' => 'Comentários e sugestões do aluno na disciplina',
                'maxlength' => 400,
                'rows' => 3,
                'options' => '',
                'rules' => 'max:400',
            ],
            'ativo' => 1,
        ]);

        \App\Models\Questao::create([
            'campo' => [
                'type' => 'textarea',
                'text' => 'Comentários e sugestões gerais',
                'maxlength' => 400,
                'rows' => 3,
                'options' => '',
                'rules' => 'max:400',
            ],
            'ativo' => 1,
        ]);
    }
}
