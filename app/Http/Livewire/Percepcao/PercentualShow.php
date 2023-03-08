<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Percepcao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Replicado\Graduacao;

class PercentualShow extends Component
{
    public $percepcao;
    public $disciplina;
    public $percepcaoSelected;
    public $options;
    public $optionDisciplinas;
    public $path;
    public $totalAlunosMatriculadosNaDisciplina;
    public $porcentagemDeRespostasValidas;

    public function mount()
    {
        $this->path = explode('/', request()->path());

        if (Auth::user()->can('admin') || Auth::user()->can('gerente')) {
            $percepcaos = Percepcao::get(['id', 'ano', 'semestre']);
        } elseif (Gate::allows('verifica-aluno')) {
            $percepcaos = Percepcao::where('liberaConsultaAluno', true)->get(['id', 'ano', 'semestre']);
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
    }

    public function updatedPercepcaoSelected($percepcaoId)
    {
        if (!empty($percepcaoId)) {
            $this->percepcao = Percepcao::find($percepcaoId);

            $disciplinas = DB::table('disciplinas')
                ->select('id', 'coddis', 'verdis', 'codtur', 'nomdis', 'tiptur', 'nompes')
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
                ->groupBy('id', 'coddis', 'verdis', 'codtur', 'codpes', 'nomdis', 'tiptur', 'nompes')
                ->get();

            foreach ($disciplinas as $disciplina) {
                $this->totalAlunosMatriculadosNaDisciplina[$disciplina->id] = Graduacao::contarAlunosMatriculadosTurma($disciplina->coddis, $disciplina->verdis, $disciplina->codtur);
                $this->porcentagemDeRespostasValidas[$disciplina->id] = number_format($disciplina->total_de_respostas * 100 / $this->totalAlunosMatriculadosNaDisciplina[$disciplina->id], 2) . '%  dos alunos';
            }

            $this->optionDisciplinas = $disciplinas;
        }
    }

    public function render()
    {
        return view('livewire.percepcao.percentual-show')->extends('layouts.app')->section('content');;
    }
}
