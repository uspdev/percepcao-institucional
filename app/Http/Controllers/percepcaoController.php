<?php

namespace App\Http\Controllers;

use App\Models\Percepcao;
use App\Models\Disciplina;
use App\Replicado\Graduacao;
use Illuminate\Http\Request;

class percepcaoController extends Controller
{
    /**
     * Retorna lista de alunos matriculados em uma percepção
     * 
     * @param $id - id da Percepção
     */
    public function alunos(Int $id)
    {
        $percepcao = Percepcao::find($id);
        $alunos = Graduacao::listarAlunos($anoSemestre = $percepcao->ano . $percepcao->semestre);
        $percepcao->addSettings(['totalDeAlunosMatriculados' => count($alunos)]);
        $percepcao->save();

        return view('percepcao.alunos', compact('percepcao', 'alunos'));
    }

    /**
     * Retorna lista de disciplinas para um aluno
     * 
     * No contexto de uma requisição ajax
     * 
     * @return String lista formatada em HTML
     */
    public function listarDisciplinasAluno(Int $percepcao_id, Int $codpes)
    {
        $percepcao = Percepcao::find($percepcao_id);

        $anoSemestre = $percepcao->ano . $percepcao->semestre;
        $disciplinas = Graduacao::listarDisciplinasAlunoAnoSemestre($codpes, $anoSemestre);
        $html = '';
        foreach ($disciplinas as $disciplina) {
            $html .= $disciplina['coddis'] . '-' . $disciplina['nomdis'] . '<br>';
        }
        return $html;
    }

    public function disciplinas(Request $request, Int $percepcao_id)
    {
        $percepcao = Percepcao::find($percepcao_id);
        if ($percepcao->disciplinas->isEmpty()) {
            Disciplina::importarDoReplicado($percepcao);
            $request->session()->flash('alert-info', 'Disciplinas importadas do replicado');
            $disciplinas = Disciplina::where('percepcao_id', $percepcao->id)->get();
        } else {
            $disciplinas = $percepcao->disciplinas;
        }

        return view('percepcao.disciplinas', compact('percepcao', 'disciplinas'));
    }

    public function disciplinasUpdate(Request $request, Int $percepcao_id)
    {
        $request->validate([
            'acao' => 'in:atualizar',
        ]);

        $percepcao = Percepcao::find($percepcao_id);
        Disciplina::where('percepcao_id', $percepcao->id)->delete();
        $count = Disciplina::importarDoReplicado($percepcao);
        $request->session()->flash('alert-info', 'Disciplinas recarregadas do replicado');

        return back();
    }
}
