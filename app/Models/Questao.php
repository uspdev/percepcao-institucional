<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questao extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['campo' => 'array'];

    public function getCamposQuestao($id)
    {
        $questao = $this::where('id', $id)->get();

        $plucked = $questao->pluck('campo.options')->toArray();

        $keys = array_column($plucked[0], 'key');
        $values = array_column($plucked[0], 'value');

        $optionValues = [
            'keys' => $keys,
            'values' => $values,
        ];

        return $optionValues;
    }

    /**
     * Relacionamento com os grupos
     */
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class)
            ->as('grupo')
            ->withTimestamps()
            ->withPivot('ordem')
            ->with('childGrupos')
            ->orderBy('ordem');
    }

    public static function listarRespostas($questao, $disciplina)
    {
        $respostas = Resposta::where('questao_id', $questao->id)->where('disciplina_id', $disciplina->id)->get('resposta')->toArray();
        return Arr::flatten($respostas);
    }

    /**
     * Relacionamento com as respostas
     */
    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }
}
