<?php

namespace App\Http\Controllers;

use App\Models\Percepcao;
use App\Models\Disciplina;
use App\Replicado\Graduacao;
use Illuminate\Http\Request;

class percepcaoController extends Controller
{

    public function show(Percepcao $percepcao)
    {
        $membrosEspeciais = $percepcao->settings['membrosEspeciais'];

        return view('percepcao.show', compact('percepcao', 'membrosEspeciais'));
    }

    /**
     * Update membros especiais de uma percepção
     * 
     * @param App\Models\Percepcao $percepcao
     */
    public function updateEspeciais(Percepcao $percepcao, Request $request)
    {
        $request->validate([
            'codpes' => ['required', 'numeric'],
        ]);

        $membrosEspeciais = array_merge($percepcao->settings['membrosEspeciais'], [$request['codpes']]);
        $percepcao->addSettings(['membrosEspeciais' => $membrosEspeciais]);
        $percepcao->save();
        return back();
    }

    /**
     * Destroy membros especiais de uma percepção
     * 
     * @param App\Models\Percepcao $percepcao
     */
    public function destroyEspeciais(Percepcao $percepcao, Request $request)
    {
        $request->validate([
            'codpes' => ['nullable', 'numeric'],
        ]);

        $membrosEspeciais = array_diff($percepcao->settings['membrosEspeciais'], [$request['codpes']]);
        $percepcao->addSettings(['membrosEspeciais' => $membrosEspeciais]);
        $percepcao->save();
        return back();
    }

    /**
     * Retorna lista de alunos matriculados em uma percepção
     * 
     * @param App\Models\Percepcao $percepcao
     */
    public function alunos(Percepcao $percepcao)
    {
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
     * @param App\Models\Percepcao $percepcao
     * @param Int $codpes
     * @return String lista formatada em HTML
     */
    public function listarDisciplinasAluno(Percepcao $percepcao, Int $codpes)
    {
        // $percepcao = Percepcao::find($percepcao_id);

        $anoSemestre = $percepcao->ano . $percepcao->semestre;
        $disciplinas = Graduacao::listarDisciplinasAlunoAnoSemestre($codpes, $anoSemestre);
        $html = '';
        foreach ($disciplinas as $disciplina) {
            $html .= $disciplina['coddis'] . '-' . $disciplina['nomdis'] . '<br>';
        }
        return $html;
    }

    /**
     * Lista as disciplinas (turmas) da percepção.
     * 
     * Caso não tenha nada no BD, popula ele.
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Models\Percepcao $percepcao
     */
    public function disciplinas(Request $request, Percepcao $percepcao)
    {
        if ($percepcao->disciplinas->isEmpty()) {
            Disciplina::importarDoReplicado($percepcao);
            $request->session()->flash('alert-info', 'Disciplinas importadas do replicado');
            $disciplinas = Disciplina::where('percepcao_id', $percepcao->id)->get();
        } else {
            $disciplinas = $percepcao->disciplinas;
        }

        return view('percepcao.disciplinas', compact('percepcao', 'disciplinas'));
    }

    /**
     * Atualiza a lista de disciplinas de uma percepcao
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Models\Percepcao $percepcao
     */
    public function disciplinasUpdate(Request $request, Percepcao $percepcao)
    {
        $request->validate([
            'acao' => 'in:atualizar',
        ]);

        Disciplina::where('percepcao_id', $percepcao->id)->delete();
        $count = Disciplina::importarDoReplicado($percepcao);
        $request->session()->flash('alert-info', 'Disciplinas recarregadas do replicado');

        return back();
    }
}
