<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Percepcao;
use App\Models\PercepcaoAvaliacao;
use App\Models\PercepcaoAvaliacaoComentario;
use Uspdev\Replicado\Graduacao;
use Uspdev\Replicado\Pessoa;

class PercepcaoAvaliacaoCreate extends Component
{
    public $percepcao;    
    public $disciplinas;
    public $pessoa;
    public $idPercepcao;
    public $disciplinaQuesitos = [];
    public $alunoQuesitos = [];
    public $avaliacaoQuesitos = [];
    public $comentariosESugestoesGerais;    
    public $statusPercepcao = null;
    public $limiteComentariosDisciplina = 100;
    public $limiteComentarioGeral = 400;
    protected $rules = [];
    protected $messages = [];

    public function mount(Request $request, $idPercepcao = null)
    {

        if (is_numeric($idPercepcao)) {
            $this->percepcao = Percepcao::find($idPercepcao);
        } else {
            $ano = date('Y');
            $semestre = (date('m') <= '06') ? 1 : 2;
            $this->percepcao = Percepcao::where('ano', $ano)->where('semestre', $semestre)->first();
        }

        if ($this->percepcao) {
            if ($this->percepcao->dataDeAbertura > date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional estará disponível a partir de: " . $this->percepcao->dataDeAbertura->format('d/m/Y \à\s H:i:s') . ".";
            }

            if ($this->percepcao->dataDeFechamento < date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional deste semestre foi finalizada em: " . $this->percepcao->dataDeFechamento->format('d/m/Y \à\s H:i:s') . ".<br />Obrigado pela sua colaboração.";
            }
            
            if ($request->is("avaliar/preview/$idPercepcao")) {
                $this->disciplinas = config('percepcao.disciplinas_fake');
                $this->statusPercepcao = null;
            } else {
                $this->disciplinas = Graduacao::listarDisciplinasAlunoAnoSemestre(10407152, 20212);
            }

            $this->pessoa = Pessoa::class;

            $this->disciplinaQuesitos = [
                'assiduidadePontualidade'                                           => 'Assiduidade/Pontualidade',
                'apresentacaoCumprimentoDoPlanoDeEnsino'                            => 'Apresentação/Cumprimento do plano de ensino',
                'conhecimentoAtualizacaoDaMateria'                                  => 'Conhecimento/Atualização da matéria',
                'utilizacaoDaBibliografiaBasicaNaDisciplina'                        => 'Utilizacao da bibliografia básica na disciplina',
                'clarezaNaExposicaoDosConteudos'                                    => 'Clareza na exposição dos conteúdos',
                'relacionamentoEntreAspectosTeoricosEPraticosDaDisciplina'          => 'Relacionamento entre aspectos teóricos e práticos da disciplina',
                'didaticaDinamismoClarezaEOrganizacaoNaExposicaoDeTemasNasAulas'    => 'Didática (dinamismo, clareza e organização na exposição de temas) nas aulas ministradas',
                'coerenciaEntreConteudoMinistradoEAvaliacoesAplicadas'              => 'Coerência entre conteúdo ministrado e avaliações aplicadas',
                'interesseEmEsclarecerAsDuvidasDosAlunos'                           => 'Interesse em esclarecer as dúvidas dos alunos',
                'relacionamentoComOsAlunos'                                         => 'Relacionamento com os alunos',
            ];

            $this->alunoQuesitos = [
                'assiduidadePontualidadeAluno'                                      => 'Assiduidade/Pontualidade',
                'compromissoAluno'                                                  => 'Compromisso',
                'participacaoNasAulasAluno'                                         => 'Participação nas aulas',
                'relacionamentoComOsColegasProfessoresEPessoalAdministrativoAluno'  => 'Relacionamento com os colegas, professores e pessoal administrativo',
                'cumprimentoDasAtividadesRecomendadasAluno'                         => 'Cumprimento das atividades recomendadas'
            ];

            foreach ($this->disciplinas as $key => $disciplina) {
                $this->avaliacaoQuesitos[$key]['percepcao_id'] = $this->percepcao->id;
                $this->avaliacaoQuesitos[$key] = array_merge($this->avaliacaoQuesitos[$key], [
                    'ministranteDaDisciplina' => (is_numeric($disciplina['codpes'])) ? $this->pessoa::obterNome($disciplina['codpes']) : $disciplina['codpes'],
                    'codigoDaDisciplina'      => $disciplina['coddis'],
                    'nomeDaDisciplina'        => $disciplina['nomdis'],
                    'versaoDaDisciplina'      => $disciplina['verdis'],
                    'codigoDaTurma'           => $disciplina['codtur'],
                    'tipoDaTurma'             => trim($disciplina['tiptur']),
                ]);
                $this->avaliacaoQuesitos[$key] = array_merge($this->avaliacaoQuesitos[$key], $this->disciplinaQuesitos);
                $this->avaliacaoQuesitos[$key] = array_merge($this->avaliacaoQuesitos[$key], $this->alunoQuesitos);
                $this->avaliacaoQuesitos[$key]['comentariosESugestoesDoAluno'] = '';
                $this->avaliacaoQuesitos[$key]['user_id'] = Auth::id();
            }
        }
    }

    protected function rules()
    {
        foreach ($this->avaliacaoQuesitos as $keyQuesito => $valueQuesito) {
            foreach ($valueQuesito as $keyDetalheQuesitos => $valueDetalheQuesitos) {
                if (in_array($keyDetalheQuesitos, array_keys($this->disciplinaQuesitos)) || in_array($keyDetalheQuesitos, array_keys($this->alunoQuesitos))) {
                    $this->rules = array_merge($this->rules, [
                        "avaliacaoQuesitos.$keyQuesito.$keyDetalheQuesitos" => 'integer',
                    ]);
                    $this->messages = array_merge($this->messages, [
                        "avaliacaoQuesitos.$keyQuesito.$keyDetalheQuesitos.integer" => "O campo <strong>$valueDetalheQuesitos</strong> da disciplina <strong>". $valueQuesito['nomeDaDisciplina'] . "</strong> precisa ser preenchido.",
                    ]);
                }

                if ($keyDetalheQuesitos == 'comentariosESugestoesDoAluno') {
                    $this->rules = array_merge($this->rules, [
                        "avaliacaoQuesitos.$keyQuesito.comentariosESugestoesDoAluno" => 'max:500',
                    ]);
                    $this->messages = array_merge($this->messages, [
                        "avaliacaoQuesitos.$keyQuesito.comentariosESugestoesDoAluno.max" => "O campo <strong>$keyDetalheQuesitos</strong> da disciplina <strong>". $valueQuesito['nomeDaDisciplina'] . "</strong> não pode conter mais de :max caracteres.",
                    ]);
                }
            }
        }

        return $this->rules;
    }

    public function updated($propertyName)
    {
        $validated = $this->validateOnly($propertyName, $this->rules());
    }

    public function save()
    {
        $validated = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($this->rules()) {
                    if ($validator->errors()->any()) {
                        $validator->errors()->add('disciplina', 'Todos os quesitos precisam ser respondidos');
                    }
                }
            });
        })->validate();

        foreach ($this->avaliacaoQuesitos as $valueQuesitos) {
          $created = PercepcaoAvaliacao::create($valueQuesitos);
        }

        if ($this->comentariosESugestoesGerais) {
            PercepcaoAvaliacaoComentario::create([
                'percepcao_id' => $this->percepcao->id,
                'comentariosESugestoesGerais' => $this->comentariosESugestoesGerais,
                'user_id' => Auth::id(),
            ]);
        }

        $this->reset();

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.percepcao.percepcao-avaliacao-create')->extends('layouts.app')->section('content');
    }
}
