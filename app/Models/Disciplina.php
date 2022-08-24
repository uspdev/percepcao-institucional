<?php

namespace App\Models;

use App\Replicado\Graduacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function contarRespostas()
    {
        if ($this->respostas->count()) {
            return $this->respostas->groupBy('questao_id')->first()->count();
        } else {
            return 0;
        }
    }

    public function contarMatriculados() {
        return Graduacao::contarAlunosMatriculadosTurma($this->coddis, $this->verdis, $this->codtur);
    }

    /**
     * relacao com respostas
     */
    public function respostas()
    {
        return $this->hasMany('App\Models\Resposta');
    }
}
