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

    public function mount()
    {
        $this->path = explode('/', request()->path());

        $percepcaos = Percepcao::get(['id', 'ano', 'semestre']);

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
                    ->where('disciplinas.percepcao_id', $this->percepcao->id)
                    ->groupBy('coddis', 'verdis', 'codtur', 'codpes', 'nomdis', 'tiptur', 'nompes')
                    ->get();

                foreach ($disciplinas as $disciplina) {
                    $totalDeRespostas = is_null($disciplina->total_de_respostas) ? 0 : $disciplina->total_de_respostas;

                    $this->optionDisciplinas[$disciplina->id] = $disciplina->coddis . ' - V' . $disciplina->verdis . ' - ' . $disciplina->nomdis . ' - ' . $disciplina->codtur . ' - ' . $disciplina->tiptur . ' - ' . $disciplina->nompes . ' (' . $totalDeRespostas . ')';
                }

                $this->disciplinaSelected = isset($this->disciplina->id) ? $this->disciplina->id : '';
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

    public function updatedDisciplinaSelected($disciplinaId)
    {
        $this->disciplina = Disciplina::find($disciplinaId);
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
