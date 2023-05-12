<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Coordenador;
use App\Models\Disciplina;
use App\Models\Grupo;
use App\Models\Percepcao;
use App\Models\Questao;
use App\Models\Resposta;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Gate;

class RelatorioShow extends Component
{
    public $percepcao;
    public $disciplina;
    public $percepcaoSelected;
    public $disciplinaSelected;
    public $coordenadorSelected;
    public $options;
    public $optionDisciplinas;
    public $optionCoordenadores;
    public $path;
    public $temResposta;

    public function mount()
    {
        $this->path = explode('/', request()->path());

        if (Auth::user()->can('admin') || Auth::user()->can('gerente')) {
            $percepcaos = Percepcao::get(['id', 'ano', 'semestre']);
        } elseif (Gate::allows('verifica-membro-especial')) {
            $percepcaos = Percepcao::where('liberaConsultaMembrosEspeciais', true)->orWhere('liberaConsultaDocente', true)->get(['id', 'ano', 'semestre']);
        } elseif (Gate::allows('verifica-docente')) {
            $percepcaos = Percepcao::where('liberaConsultaDocente', true)->get(['id', 'ano', 'semestre']);
        } else {
            $percepcaos = '';
        }

        if ($percepcaos->count()) {
            foreach ($percepcaos as $percepcao) {
                $this->options[$percepcao->id] = $percepcao->id . ' - ' . $percepcao->semestre . '/' . $percepcao->ano;
            }
        } else {
            $this->options = ['Nenhuma percepção foi encontrada'];
        }

        $this->percepcaoSelected = '';
        $this->disciplinaSelected = '';
        $this->coordenadorSelected = '';
    }

    public function updatedPercepcaoSelected($percepcaoId)
    {
        if ($percepcaoId) {
            if (isset($this->disciplina)) {
                unset($this->disciplina);
            }

            $this->optionDisciplinas = [];

            $this->optionCoordenadores = [];

            $this->percepcao = Percepcao::find($percepcaoId);

            if ($this->percepcao->questaos()->has('grupos')) {
                $temDisciplina = false;

                $temCoordenador = false;

                foreach ($this->percepcao->questaos()->get('grupos') as $grupo) {
                    if (isset($grupo['modelo_repeticao']) && $grupo['modelo_repeticao'] === 'disciplinas') {
                        $temDisciplina = true;
                    }

                    if (isset($grupo['modelo_repeticao']) && $grupo['modelo_repeticao'] === 'coordenadores') {
                        $temCoordenador = true;
                    }
                }

                if ($temDisciplina) {
                    $disciplinas = DB::table('disciplinas')
                        ->select('coddis', 'verdis', 'codtur', 'nomdis', 'tiptur', 'nompes')
                        ->selectRaw('MIN(id) id,
                            MIN(
                                (
                                    SELECT
                                        COUNT(R1.questao_id)
                                    FROM
                                        respostas R1
                                    WHERE
                                        R1.percepcao_id = disciplinas.percepcao_id and R1.disciplina_id = disciplinas.id
                                    GROUP BY
                                        R1.questao_id
                                    LIMIT 0,1)
                            ) AS total_de_respostas'
                        )
                        ->where('disciplinas.percepcao_id', $this->percepcao->id);
                    // Se for um docente que estiver consultando, restringe os resultados apenas às disciplinas dele próprio
                    if (Gate::allows('verifica-docente') && (!Gate::allows('verifica-membro-especial') || !Gate::allows('membrosEspeciais', $this->percepcao)) && (!Auth::user()->can('admin') || !Auth::user()->can('gerente'))) {
                        $disciplinas = $disciplinas
                            ->where('disciplinas.codpes', Auth::user()->codpes);
                    }
                    $disciplinas = $disciplinas
                        ->groupBy('coddis', 'verdis', 'codtur', 'codpes', 'nomdis', 'tiptur', 'nompes')
                        ->get();

                    if ($disciplinas->count()) {
                        foreach ($disciplinas as $disciplina) {
                            $totalDeRespostas = is_null($disciplina->total_de_respostas) ? 0 : $disciplina->total_de_respostas;

                            $this->optionDisciplinas[$disciplina->id] = $disciplina->coddis . ' - V' . $disciplina->verdis . ' - ' . $disciplina->nomdis . ' - ' . $disciplina->codtur . ' - ' . $disciplina->tiptur . ' - ' . $disciplina->nompes . ' (' . $totalDeRespostas . ')';
                        }

                        $this->disciplinaSelected = isset($this->disciplina->id) ? $this->disciplina->id : '';
                    } else {
                        $this->disciplinaSelected = 0;
                        $this->optionDisciplinas = ['Nenhuma disciplina sob sua responsabilidade foi encontrada'];
                    }
                } else {
                    $this->disciplinaSelected = 0;
                    $this->optionDisciplinas = ['Nenhuma avaliação de disciplina foi enviada'];
                }

                if ($temCoordenador) {
                    $coordenadores = Coordenador::where('percepcao_id', $this->percepcao->id)->get();

                    foreach ($coordenadores as $coordenador) {
                        $this->optionCoordenadores[$coordenador->id] = $coordenador->codcur . ' - ' . $coordenador->codhab . ' - ' . $coordenador->nomcur . ' - ' . $coordenador->nompes;
                    }
                    $this->coordenadorSelected = isset($this->coordenador->id) ? $this->coordenador->id : '';
                } else {
                    $this->coordenadorSelected = 0;
                    $this->optionCoordenadores = ['Nenhuma avaliação de coordenador foi enviada'];
                }
            }
        }
    }

    public function updatedDisciplinaSelected($disciplinaId)
    {
        $this->disciplina = Disciplina::find($disciplinaId);

        if (Gate::allows('verifica-docente') && (!Gate::allows('verifica-membro-especial') || !Gate::allows('membrosEspeciais', $this->percepcao)) && (!Auth::user()->can('admin') || !Auth::user()->can('gerente'))) {
            if ($this->disciplina->codpes !== Auth::user()->codpes) {
                abort(403);
            }
        }

        $this->temResposta = $this->disciplina->contarRespostas($this->percepcao->id) > 0 ? true : false;
    }

    public function updatedCoordenadorSelected($coordenadorId)
    {
        $this->coordenador = Coordenador::find($coordenadorId);
    }

    public function getDetalheGrupo($grupoId)
    {
        return Grupo::find($grupoId)->toArray();
    }

    public function getDetalheQuestao($questaoId)
    {
        return Questao::find($questaoId)->toArray();
    }

    public function getRespostas($grupoId, $questaoId, $percepcaoId, $disciplinaId = null, $coordenadorId = null)
    {
        $this->grupoId = $grupoId;

        $this->questaoId = $questaoId;

        $respostas = Resposta::where('grupo_id', $grupoId)
            ->where('questao_id', $questaoId)
            ->where('percepcao_id', $percepcaoId);

        if (!is_null($disciplinaId)) {
            $respostas = $respostas->where('disciplina_id', $disciplinaId);
        }

        if (!is_null($coordenadorId)) {
            $respostas = $respostas->where('coordenador_id', $coordenadorId);
        }

        $respostas = $respostas->get();

        return $valoresResposta = $respostas->pluck('resposta')->toArray();
    }

    public function render()
    {
        return view('livewire.percepcao.relatorio-show')->extends('layouts.app')->section('content');
    }
}
