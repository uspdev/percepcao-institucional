<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Percepcao;
use App\Replicado\Estrutura;
use App\Replicado\Graduacao;
use App\Replicado\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class percepcaoController extends Controller
{

    public function show(Percepcao $percepcao)
    {
        $membrosEspeciais = empty($percepcao->settings['membrosEspeciais']) ? [] : Pessoa::obterNome($percepcao->settings['membrosEspeciais']);

        $departamentos = collect(Estrutura::listarSetores())->where('tipset', 'Departamento de Ensino');

        return view('percepcao.show', compact('percepcao', 'membrosEspeciais', 'departamentos'));
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
        } 
        $disciplinas = Disciplina::where('percepcao_id', $percepcao->id)->get();

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
        if (!$percepcao->isFuturo()) {
            $request->session()->flash('alert-danger', 'Impossível atualizar se não estiver em elaboração');
            return back();
        }

        $request->validate([
            'acao' => 'in:atualizar',
        ]);

        Disciplina::where('percepcao_id', $percepcao->id)->delete();
        $count = Disciplina::importarDoReplicado($percepcao);
        $request->session()->flash('alert-info', 'Disciplinas recarregadas do replicado');

        return back();
    }

    /**
     * Exporta o resultado das disciplinas para csv
     *
     * @param Illuminate\Http\Request $request
     * @param App\Models\Percepcao $percepcao
     * @param String $nomabvset
     */
    public function exportDisciplinaCsv(Request $request, Percepcao $percepcao, $nomabvset)
    {
        $departamentos = collect(Estrutura::listarSetores())->where('tipset', 'Departamento de Ensino');

        $disciplinas = Disciplina::where('percepcao_id', $percepcao->id);
        if ($nomabvset === 'all') {
            foreach ($departamentos as $departamento) {
                $disciplinas = $disciplinas->where('coddis', 'NOT LIKE', $departamento['nomabvset'] . '%');
            }
        } else {
            $disciplinas = $disciplinas->where('coddis', 'LIKE', $nomabvset . '%');
        }
        $disciplinas = $disciplinas->orderBy('coddis')
            ->get();

        $columnsEstatisticaName = [];
        $columnsEstatisticaValue = [];
        $columnsTextoName = [];
        $columnsTextoValue = [];

        foreach ($disciplinas as $key => $disciplina) {
            // $totalDeAlunosMatriculados = Graduacao::contarTotalDeAlunosMatriculadosNaDisciplina($disciplina->coddis, $disciplina->codtur, $disciplina->verdis, $disciplina->tiptur);
            $totalDeAlunosMatriculados = Graduacao::contarAlunosMatriculadosTurma($disciplina->coddis, $disciplina->verdis, $disciplina->codtur);

            // para o caso de não ter alunos matriculados
            if (!$totalDeAlunosMatriculados) {
                continue;
            }

            $respostasEstatistica = DB::table('respostas')->join('questaos', 'respostas.questao_id', '=', 'questaos.id')
                ->select('questaos.campo->text as texto', 'questao_id', DB::raw('ROUND(AVG(resposta),2) as quantity'), DB::raw('COUNT(*) as totalDeRespostasValidas'))
                ->where('percepcao_id', $percepcao->id)
                ->where('disciplina_id', $disciplina->id)
                ->where('questaos.campo->type', 'radio')
                ->groupBy('percepcao_id', 'disciplina_id', 'respostas.questao_id', 'questaos.campo')
                ->get();

            $respostasTexto = DB::table('respostas')->join('questaos', 'respostas.questao_id', '=', 'questaos.id')
                ->select('questaos.campo->text as texto', 'questao_id', 'resposta')
                ->where('percepcao_id', $percepcao->id)
                ->where('disciplina_id', $disciplina->id)
                ->where('questaos.campo->type', 'textarea')
                ->groupBy('percepcao_id', 'disciplina_id', 'respostas.questao_id', 'questaos.campo', 'resposta')
                ->get();

            foreach ($respostasEstatistica as $keyResposta => $resposta) {
                $totalDeRespostasValidasEstatistica[$key] = $resposta->totalDeRespostasValidas;

                $respostasEstatisticaColumnName[$keyResposta] = $resposta->texto;
                $respostasEstatisticaColumnValue[$key][$keyResposta] = $resposta->quantity;
            }

            $totalDeRespostasValidasTexto[$key] = 0;
            foreach ($respostasTexto as $keyResposta => $resposta) {
                $totalDeRespostasValidasTexto[$key] += 1;

                $respostasTextoColumnName[$keyResposta] = $resposta->texto . ' - Aluno ' . ($keyResposta + 1);
                $respostasTextoColumnValue[$key][$keyResposta] = $resposta->resposta;
            }

            if (isset($respostasEstatisticaColumnName) || isset($respostasTextoColumnName)) {

                $columnsName = [
                    'codigoDaDisciplina',
                    'nomeDaDisciplina',
                    'ministranteDaDisciplina',
                    'versaoDaDisciplina',
                    'codigoDaTurma',
                    'tipoDaTurma',
                    'totalDeAlunosMatriculados',
                    'totalDeRespostasValidas',
                    'porcentagemDeRespostasValidas',
                ];

                $columnsEstatisticaName = array_merge($columnsName, $respostasEstatisticaColumnName);

                $columnsTextoName = array_merge($columnsName, $respostasTextoColumnName);

                $columnsValue[$key] = [
                    $disciplina->coddis,
                    $disciplina->nomdis,
                    $disciplina->nompes,
                    $disciplina->verdis,
                    $disciplina->codtur,
                    $disciplina->tiptur,
                    $totalDeAlunosMatriculados,
                ];

                if (isset($respostasEstatisticaColumnValue[$key])) {
                    $porcentagemDeRespostasValidas = ($totalDeRespostasValidasEstatistica[$key] * 100) / $totalDeAlunosMatriculados;

                    $respostasEstatisticaColumnValue[$key] = array_merge([
                        $totalDeRespostasValidasEstatistica[$key],
                        round($porcentagemDeRespostasValidas, 2) . '%',
                    ], $respostasEstatisticaColumnValue[$key]);

                    $columnsEstatisticaValue[$key] = array_merge($columnsValue[$key], $respostasEstatisticaColumnValue[$key]);
                }

                if (isset($respostasTextoColumnValue[$key])) {
                    $porcentagemDeRespostasValidas = ($totalDeRespostasValidasTexto[$key] * 100) / $totalDeAlunosMatriculados;

                    $respostasTextoColumnValue[$key] = array_merge([
                        $totalDeRespostasValidasTexto[$key],
                        round($porcentagemDeRespostasValidas, 2) . '%',
                    ], $respostasTextoColumnValue[$key]);

                    $columnsTextoValue[$key] = array_merge($columnsValue[$key], $respostasTextoColumnValue[$key]);
                }
            } else {
                $request->session()->flash('alert-danger', "Nenhum resultado encontrado para este tipo de relatório!");

                return back();
            }
        }

        $nomabvset = ($nomabvset === 'all') ? 'demais_departamentos' : $nomabvset;

        $fileName = 'resultado_media_percepcao_institucional_' . $percepcao->semestre . '_' . $percepcao->ano . '_' . $nomabvset . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($columnsEstatisticaName, $columnsEstatisticaValue, $columnsTextoName, $columnsTextoValue) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            if (!empty($columnsEstatisticaName)) {
                fputcsv($file, $columnsEstatisticaName);

                foreach ($columnsEstatisticaValue as $value) {
                    fputcsv($file, $value);
                }
            }

            if (!empty($columnsTextoName)) {
                fputcsv($file, ["\t"]);
                fputcsv($file, ['RESPOSTAS TEXTUAIS']);
                fputcsv($file, $columnsTextoName);

                foreach ($columnsTextoValue as $value) {
                    fputcsv($file, $value);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
