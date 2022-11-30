<?php

namespace App\Models;

use App\Replicado\Graduacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Services\Grafico;

class Disciplina extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Importa do replicado as disciplinas a serem avaliadas no ano/semestre informado
     *
     * @param \App\Models\Percepcao $percepcao
     * @return Int - Total de disciplinas importadas
     */
    public static function importarDoReplicado($percepcao)
    {
        $disciplinas = Graduacao::listarTurmasUnidade($percepcao->ano . $percepcao->semestre);

        // adicionando coluna percepcao_id não presente no replicado
        $disciplinas = array_map(function ($disciplina) use ($percepcao) {
            $disciplina['percepcao_id'] = $percepcao->id;
            $disciplina['created_at'] = now();
            $disciplina['updated_at'] = now();
            return $disciplina;
        }, $disciplinas);

        Disciplina::insert($disciplinas);
        $percepcao->addSettings(['totalDeDisciplinas' => count($disciplinas)]);
        $percepcao->save();
        return count($disciplinas);
    }

    /**
     * Conta o nro de respostas para uma dada disciplina já filtrada por percepcao
     */
    public function contarRespostas($percepcaoId)
    {
        if ($this->respostas->where('percepcao_id', $percepcaoId)->count()) {
            return $this->respostas->where('percepcao_id', $percepcaoId)->groupBy('questao_id')->first()->count();
        } else {
            return 0;
        }
    }

    public function contarMatriculados()
    {
        return Graduacao::contarAlunosMatriculadosTurma($this->coddis, $this->verdis, $this->codtur);
    }

    public function questaos()
    {
        $percepcao = $this->percepcao;
        $settings = $percepcao->questaos()->get('grupos');
        $questaos = SELF::listarQuestaosRecursivo($settings, []);
        return $questaos;
    }

    public static function listarQuestaosRecursivo(array $grupos, array $questaos)
    {
        foreach ($grupos as $grupo) {
            if (isset($grupo['questoes'])) {
                $questaoObj = [];
                foreach ($grupo['questoes'] as $questao) {
                    $questaoObj[] = Questao::find($questao['id']);
                }
                $questaos = array_merge($questaos, $questaoObj);
            }
            if (isset($grupo['grupos'])) {
                $questaos = SELF::listarQuestaosRecursivo($grupo['grupos'], $questaos);
            }
        }
        return $questaos;
    }

    public function obterRelatorio()
    {
        $disciplina = $this;

        // obtem as questoes independente do grupo
        $questaos = $disciplina->questaos();

        foreach ($questaos as &$questao) {
            if ($questao->campo['type'] == 'radio') {
                $respostasRaw = $questao->listarRespostas($questao, $disciplina);
                $respostasCount = array_count_values($respostasRaw);
                $questao->totalRespostas = array_sum($respostasCount);

                $options = $questao->campo['options'];
                foreach ($options as &$option) {
                    $option['contagem'] = $respostasCount[$option['key']] ?? 0;
                }
                $respostas = $options;
                $questao['options'] = $respostas;
                $questao->bargraph = Grafico::barras($options);
            }
            if ($questao->campo['type'] == 'textarea') {
                $respostasRaw = $questao->listarRespostas($questao, $disciplina);
                $questao['respostasTextuais'] = array_values(array_filter($respostasRaw));
                $questao->totalRespostas = count($questao['respostasTextuais']);
            }
        }
        return $questaos;

    }

    /**
     * relacao com respostas
     */
    public function respostas()
    {
        return $this->hasMany('App\Models\Resposta');
    }

    /**
     * relacao com percepcaos
     */
    public function percepcao()
    {
        return $this->belongsTo('App\Models\Percepcao');
    }

}
