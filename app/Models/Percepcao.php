<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Percepcao extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'percepcao';

    protected $dates = [
        'created_at',
        'updated_at',
        'dataAbertura',
        'dataFechamento'
    ];

    public static function simNao() {
      return [
        'Sim',
        'Não'
      ];
    }

    public function setDataAberturaAttribute($dataAbertura) {
      $this->attributes['dataAbertura'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataAbertura)->toDateTimeString();
    }

    public function setDataFechamentoAttribute($dataFechamento) {
      $this->attributes['dataFechamento'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataFechamento)->toDateTimeString();
    }
}
