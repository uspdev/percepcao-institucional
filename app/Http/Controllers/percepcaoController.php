<?php

namespace App\Http\Controllers;

use App\Models\Percepcao;
use Illuminate\Http\Request;
use App\Replicado\Graduacao;

class percepcaoController extends Controller
{
    public function alunos($id)
    {
        // $disciplinas = Graduacao::listarDisciplinasUnidade('20221');
        // print_r($disciplinas); exit;

        $percepcao = Percepcao::find($id);
        $alunos = Graduacao::listarAlunos($anoSemestre = $percepcao->ano . $percepcao->semestre);

        // dd($disciplinas[1]);

        return view('percepcao.alunos', compact('percepcao', 'alunos'));
    }

    public function listarDisciplinasAluno(Int $percepcao_id, Int $codpes)
    {
        $percepcao = Percepcao::find($percepcao_id);

        $anoSemestre = $percepcao->ano . $percepcao->semestre;
        $disciplinas = Graduacao::listarDisciplinasAlunoAnoSemestre($codpes, $anoSemestre);
        $html = '';
        foreach ($disciplinas as $disciplina) {
            $html .= $disciplina['coddis'] . '-' . $disciplina['nomdis'] . '<br>';
            // $html .= json_encode($disciplina) . '<br>';
        }
        return $html;
    }
}
