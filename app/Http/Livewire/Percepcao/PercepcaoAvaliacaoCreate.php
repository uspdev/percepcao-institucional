<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Coordenador;
use App\Models\Disciplina;
use App\Models\Percepcao;
use App\Models\Questao;
use App\Models\Resposta;
use App\Replicado\PessoaReplicado;
use Uspdev\Replicado\Graduacao;
use Uspdev\Replicado\Pessoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class PercepcaoAvaliacaoCreate extends Component
{
    public $percepcao;
    public $disciplinas;
    public $coordenadores;
    public $pessoa;
    public $idPercepcao;
    public $questaoClass;
    public $avaliacaoQuesitos = [];
    public $dadosDisciplina = [];
    public $dadosCoordenador = [];
    public $statusPercepcao = null;
    public $preview = false;
    public $path;
    protected $rules = [];
    protected $messages = [];

    public function mount($idPercepcao = null)
    {
        $this->path = request()->path();

        $this->questaoClass = new Questao();
        if (is_numeric($idPercepcao)) {
            $this->preview = true;
            $this->percepcao = Percepcao::find($idPercepcao);
        } else {
            $this->percepcao = Percepcao::obterAberto();
        }

        if ($this->percepcao) {
            if ($this->percepcao->dataDeAbertura > date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional estará disponível a partir de: " . $this->percepcao->dataDeAbertura->format('d/m/Y \à\s H:i:s') . ".";
            }

            if ($this->percepcao->dataDeFechamento < date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional deste semestre foi finalizada em: " . $this->percepcao->dataDeFechamento->format('d/m/Y \à\s H:i:s') . ".<br />Obrigado pela sua colaboração.";
            }

            $verificaEnvio = Resposta::where('percepcao_id', $this->percepcao->id)->where('user_id', Auth::id())->first();
            if (!is_null($verificaEnvio)) {
                $this->statusPercepcao = "Você já enviou uma Percepção Institucional para este ano/semestre. <br/ >Obrigado, e contamos com você na próxima percepção.";
            }

            $this->pessoa = Pessoa::class;

            if ($this->preview) {
                $this->disciplinas = config('percepcao.disciplinas_fake');
                $this->coordenadores = config('percepcao.coordenadores_fake');
                $this->statusPercepcao = null;
            } else {
                $this->disciplinas = Graduacao::listarDisciplinasAlunoAnoSemestre(
                    Auth::user()->codpes,
                    $this->percepcao->ano . $this->percepcao->semestre
                );

                $curso = Graduacao::curso(Auth::user()->codpes, env('REPLICADO_CODUNDCLG'));

                $this->coordenadores = PessoaReplicado::listarCoordenadoresDeCurso($curso['codcur'], $curso['codhab']);
            }

            $this->montaAvaliacaoQuesitoSubgrupo($this->percepcao->grupos);
        }
    }

    public function montaAvaliacaoQuesitoSubgrupo($grupos)
    {
        foreach ($grupos as $key => $grupo) {
            if ($grupo->repeticao) {
                switch ($grupo->modelo_repeticao) {
                    case 'disciplinas':
                        foreach ($this->disciplinas as $keyDisciplina => $disciplina) {
                            $this->dadosDisciplina[$keyDisciplina] = [
                                'codpes' => (is_numeric($disciplina['codpes'])) ? $disciplina['codpes'] : 111111 . $keyDisciplina,
                                'nompes' => (is_numeric($disciplina['codpes'])) ? $this->pessoa::obterNome($disciplina['codpes']) : $disciplina['codpes'],
                                'coddis' => $disciplina['coddis'],
                                'nomdis' => $disciplina['nomdis'],
                                'verdis' => $disciplina['verdis'],
                                'codtur' => $disciplina['codtur'],
                                'tiptur' => $disciplina['tiptur'],
                            ];
                            $this->avaliacaoQuesitos[$grupo->id]['disciplinas'][$keyDisciplina] = [
                                'dadosDisciplina' => $this->dadosDisciplina[$keyDisciplina]
                            ];

                            foreach ($grupo->questaos as $keyQuestao => $valueQuestao) {
                                $this->avaliacaoQuesitos[$grupo->id]['disciplinas'][$keyDisciplina][$valueQuestao->id] = [
                                    'text' => $valueQuestao->campo['text'],
                                    'value' => '',
                                    'type' => $valueQuestao->campo['type'],
                                    'rules' => $valueQuestao->campo['rules'],
                                ];
                            }
                        }
                        break;
                    case 'coordenadores':
                        foreach ($this->coordenadores as $keyCoordenador => $coordenador) {
                            $this->dadosCoordenador[$keyCoordenador] = [
                                'codpes' => (is_numeric($coordenador['codpes'])) ? $coordenador['codpes'] : 111111 . $keyCoordenador,
                                'nompes' => (is_numeric($coordenador['codpes'])) ? $this->pessoa::obterNome($coordenador['codpes']) : $coordenador['codpes'],
                                'codcur' => $coordenador['codcur'],
                                'nomcur' => $coordenador['nomcur'],
                                'codhab' => $coordenador['codhab'],
                            ];
                            $this->avaliacaoQuesitos[$grupo->id]['coordenadores'][$keyCoordenador] = [
                                'dadosCoordenador' => $this->dadosCoordenador[$keyCoordenador]
                            ];

                            foreach ($grupo->questaos as $keyQuestao => $valueQuestao) {
                                $this->avaliacaoQuesitos[$grupo->id]['coordenadores'][$keyCoordenador][$valueQuestao->id] = [
                                    'text' => $valueQuestao->campo['text'],
                                    'value' => '',
                                    'type' => $valueQuestao->campo['type'],
                                    'rules' => $valueQuestao->campo['rules'],
                                ];
                            }
                        }
                        break;
                }
            } else {
                foreach ($grupo->questaos as $keyQuestao => $valueQuestao) {
                    $this->avaliacaoQuesitos[$grupo->id][$valueQuestao->id] = [
                        'text' => $valueQuestao->campo['text'],
                        'value' => '',
                        'type' => $valueQuestao->campo['type'],
                        'rules' => $valueQuestao->campo['rules'],
                    ];
                }
            }

            if ($grupo->grupos->count()) {
                $this->montaAvaliacaoQuesitoSubgrupo($grupo->grupos);
            }
        }
    }

    protected function rules()
    {
        foreach ($this->avaliacaoQuesitos as $keyQuesito => $valueQuesito) {
            if (isset($valueQuesito['disciplinas'])) {
                foreach ($valueQuesito['disciplinas'] as $keyDisciplina => $disciplina) {
                    foreach ($disciplina as $keyValueDisciplina => $valueDisciplina) {
                        if ($keyValueDisciplina !== 'dadosDisciplina') {
                            if (isset($valueDisciplina['rules']) and !empty($valueDisciplina['rules'])) {
                                $this->rules = array_merge($this->rules, [
                                    "avaliacaoQuesitos.$keyQuesito.disciplinas.$keyDisciplina.$keyValueDisciplina.value" => $valueDisciplina['rules'],
                                ]);
                            }
                            $this->messages = array_merge($this->messages, [
                                "avaliacaoQuesitos.$keyQuesito.disciplinas.$keyDisciplina." . $keyValueDisciplina . '.value.required' => 'O campo <strong>' . $valueDisciplina['text'] . '</strong> da disciplina <strong>'. $disciplina['dadosDisciplina']['nomdis'] . '</strong> precisa ser preenchido.',
                                "avaliacaoQuesitos.$keyQuesito.disciplinas.$keyDisciplina." . $keyValueDisciplina . '.value.integer' => 'O campo <strong>' . $valueDisciplina['text'] . '</strong> da disciplina <strong>'. $disciplina['dadosDisciplina']['nomdis'] . '</strong> precisa ser preenchido.',
                                "avaliacaoQuesitos.$keyQuesito.disciplinas.$keyDisciplina." . $keyValueDisciplina . '.value.min' => 'O campo <strong>' . $valueDisciplina['text'] . '</strong> da disciplina <strong>'. $disciplina['dadosDisciplina']['nomdis'] . '</strong> não pode ter um valor inferior a :min.',
                                "avaliacaoQuesitos.$keyQuesito.disciplinas.$keyDisciplina." . $keyValueDisciplina . '.value.max' => 'O campo <strong>' . $valueDisciplina['text'] . '</strong> da disciplina <strong>'. $disciplina['dadosDisciplina']['nomdis'] . '</strong> não pode ter um valor superior a :max.',
                            ]);
                        }
                    }
                }
            } elseif (isset($valueQuesito['coordenadores'])) {
                foreach ($valueQuesito['coordenadores'] as $keyCoordenador => $coordenador) {
                    foreach ($coordenador as $keyValueCoordenador => $valueCoordenador) {
                        if ($keyValueCoordenador !== 'dadosCoordenador') {
                            if (isset($valueCoordenador['rules']) and !empty($valueCoordenador['rules'])) {
                                $this->rules = array_merge($this->rules, [
                                    "avaliacaoQuesitos.$keyQuesito.coordenadores.$keyCoordenador.$keyValueCoordenador.value" => $valueCoordenador['rules'],
                                ]);
                            }
                            $this->messages = array_merge($this->messages, [
                                "avaliacaoQuesitos.$keyQuesito.coordenadores.$keyCoordenador." . $keyValueCoordenador . '.value.required' => 'O campo <strong>' . $valueCoordenador['text'] . '</strong> do coordenador <strong>'. $coordenador['dadosCoordenador']['nompes'] . '</strong> precisa ser preenchido.',
                                "avaliacaoQuesitos.$keyQuesito.coordenadores.$keyCoordenador." . $keyValueCoordenador . '.value.integer' => 'O campo <strong>' . $valueCoordenador['text'] . '</strong> do coordenador <strong>'. $coordenador['dadosCoordenador']['nompes'] . '</strong> precisa ser preenchido.',
                                "avaliacaoQuesitos.$keyQuesito.coordenadores.$keyCoordenador." . $keyValueCoordenador . '.value.min' => 'O campo <strong>' . $valueCoordenador['text'] . '</strong> do coordenador <strong>'. $coordenador['dadosCoordenador']['nompes'] . '</strong> não pode ter um valor inferior a :min.',
                                "avaliacaoQuesitos.$keyQuesito.coordenadores.$keyCoordenador." . $keyValueCoordenador . '.value.max' => 'O campo <strong>' . $valueCoordenador['text'] . '</strong> do coordenador <strong>'. $coordenador['dadosCoordenador']['nompes'] . '</strong> não pode ter um valor superior a :max.',
                            ]);
                        }
                    }
                }
            } else {
                if (isset($valueQuesito[key($valueQuesito)]['rules']) and !empty($valueQuesito[key($valueQuesito)]['rules'])) {
                    $this->rules = array_merge($this->rules, [
                        "avaliacaoQuesitos.$keyQuesito." . key($valueQuesito) . ".value" => $valueQuesito[key($valueQuesito)]['rules'],
                    ]);
                }
                $this->messages = array_merge($this->messages, [
                    "avaliacaoQuesitos.$keyQuesito." . key($valueQuesito) . '.value.required' => 'O campo <strong>' . $valueQuesito[key($valueQuesito)]['text'] . '</strong> precisa ser preenchido.',
                    "avaliacaoQuesitos.$keyQuesito." . key($valueQuesito) . '.value.integer' => 'O campo <strong>' . $valueQuesito[key($valueQuesito)]['text'] . '</strong> precisa ser preenchido.',
                    "avaliacaoQuesitos.$keyQuesito." . key($valueQuesito) . '.value.min' => 'O campo <strong>' . $valueQuesito[key($valueQuesito)]['text'] . '</strong> não pode ter um valor inferior a :min.',
                    "avaliacaoQuesitos.$keyQuesito." . key($valueQuesito) . '.value.max' => 'O campo <strong>' . $valueQuesito[key($valueQuesito)]['text'] . '</strong> não pode ter um valor superior a :max.',
                ]);
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

        foreach ($this->avaliacaoQuesitos as $keyQuesito => $valueQuesito) {
            if (isset($valueQuesito['disciplinas'])) {
                foreach ($valueQuesito['disciplinas'] as $keyDisciplina => $valueDisciplina) {
                    $createdDisciplina = Disciplina::firstOrCreate($valueDisciplina['dadosDisciplina']);
                    if ($createdDisciplina->id) {
                        foreach ($valueDisciplina as $keyQuesitoDisciplina => $valueQuesitoDisciplina) {
                            if ($keyQuesitoDisciplina !== 'dadosDisciplina') {
                                $createdResposta = Resposta::create([
                                    'percepcao_id' => $this->percepcao->id,
                                    'grupo_id' => $keyQuesito,
                                    'questao_id' => $keyQuesitoDisciplina,
                                    'disciplina_id' => $createdDisciplina->id,
                                    'user_id' => Auth::id(),
                                    'codpes' => Auth::user()->codpes,
                                    'resposta' => $valueQuesitoDisciplina['value'],
                                ]);
                            }
                        }
                    }
                }
            } elseif (isset($valueQuesito['coordenadores'])) {
                foreach ($valueQuesito['coordenadores'] as $keyCoordenador => $valueCoordenador) {
                    $createdCoordenador = Coordenador::firstOrCreate($valueCoordenador['dadosCoordenador']);
                    if ($createdCoordenador->id) {
                        foreach ($valueCoordenador as $keyQuesitoCoordenador => $valueQuesitoCoordenador) {
                            if ($keyQuesitoCoordenador !== 'dadosCoordenador') {
                                $createdResposta = Resposta::create([
                                    'percepcao_id' => $this->percepcao->id,
                                    'grupo_id' => $keyQuesito,
                                    'questao_id' => $keyQuesitoCoordenador,
                                    'coordenador_id' => $createdCoordenador->id,
                                    'user_id' => Auth::id(),
                                    'codpes' => Auth::user()->codpes,
                                    'resposta' => $valueQuesitoCoordenador['value'],
                                ]);
                            }
                        }
                    }
                }
            } else {
                foreach ($valueQuesito as $keyValueQuesito => $valueValueQuesito) {
                    $createdResposta = Resposta::create([
                        'percepcao_id' => $this->percepcao->id,
                        'grupo_id' => $keyQuesito,
                        'questao_id' => $keyValueQuesito,
                        'user_id' => Auth::id(),
                        'codpes' => Auth::user()->codpes,
                        'resposta' => $valueValueQuesito['value'],
                    ]);
                }
            }
        }

        $this->mount($this->percepcao->id);

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.percepcao.percepcao-avaliacao-create')->extends('layouts.app')->section('content');
    }
}
