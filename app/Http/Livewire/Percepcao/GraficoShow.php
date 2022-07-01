<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Questao;
use App\Models\Resposta;
use Illuminate\Support\Str;

class GraficoShow extends Component
{
    public $percepcao;
    public $coordenador;
    public $disciplina;
    public $grupo;
    public $questao;

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

        $valoresResposta = $respostas->countBy('resposta')->sortKeys()->toArray();

        $totalDeRespostas = $respostas->count();

        $questao = Questao::find($questaoId);

        if (isset($questao->campo['options']) && !empty($questao->campo['options'])) {
            if ($questao->estatistica) {
                foreach ($questao->campo['options'] as $key => $value) {
                    if (!isset($valoresResposta[$value['key']])) {
                        $valoresResposta[$value['key']] = 0;
                    }

                    $percentual = ($totalDeRespostas > 0) ? number_format((($valoresResposta[$value['key']] / $totalDeRespostas) * 100), 1) . '%' : '0%';

                    $qtdAlunos = ' (' . $valoresResposta[$value['key']] . ' ' . Str::plural('aluno', $valoresResposta[$value['key']]) . ')';

                    $resultadosQuestao[$value['key']] = [
                        // Exibe label no padrão "Muito ruim - 30.0% (5 alunos)"
                        'texto' => "'" . $value['value'] . " - " . $percentual . $qtdAlunos . "'",
                        'total' => substr($percentual, 0, -1),
                    ];
                }

                try {
                    $media = round($respostas->avg('resposta'), 2);
                } catch (\Exception $e) {
                    $media = 0;
                }

                return [
                    'media' => $media,
                    'totalDeRespostas' => $totalDeRespostas,
                    'resultadosQuestao' => $resultadosQuestao,
                    'textoRespostas' => implode(',', array_column($resultadosQuestao, 'texto')),
                    'valorRespostas' => implode(',', array_column($resultadosQuestao, 'total')),
                ];
            } else {
                $resultadosQuestao[$value['key']] = [
                    'texto' => "'" . $value['value'] . "'",
                ];

                return [
                    'resultadosQuestao' => $resultadosQuestao,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.percepcao.grafico-show')->extends('layouts.app')->section('content');
    }
}
