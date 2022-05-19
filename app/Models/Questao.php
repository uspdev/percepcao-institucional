<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Relacionamento com as respostas
     */
    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }
}
