<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Percepcao extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'percepcaos';

    protected $dates = [
        'created_at',
        'updated_at',
        'dataDeAbertura',
        'dataDeFechamento'
    ];

    public static function simNao() {
      return [
        'Sim',
        'Não'
      ];
    }

    public function setDataDeAberturaAttribute($dataDeAbertura) {
      $this->attributes['dataDeAbertura'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeAbertura)->toDateTimeString();
    }

    public function setDataDeFechamentoAttribute($dataDeFechamento) {
      $this->attributes['dataDeFechamento'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeFechamento)->toDateTimeString();
    }

    /**
     * Relacionamento com as avaliações
     */
    public function percepcao_avaliacaos()
    {
        return $this->hasMany(PercepcaoAvaliacao::class);
    }

    /**
     * Relacionamento com as avaliações
     */
    public function percepcao_avaliacao_comentarios()
    {
        return $this->hasMany(PercepcaoAvaliacaoComentario::class);
    }
}
