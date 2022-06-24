<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Glorand\Model\Settings\Traits\HasSettingsField;

class Percepcao extends Model
{
    use HasFactory;

    use HasSettingsField;

    protected $guarded = ['id'];

    protected $table = 'percepcaos';

    protected $casts = [
        'questao_settings' => 'array',
        'settings' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'dataDeAbertura',
        'dataDeFechamento'
    ];

    // a ser usado ainda
    public $settingsDefaults = [
        'textoAgradecimentoEnvioAvaliacao' => '',
        'textoApresentacao' => '',
        'textoFormularioAvaliacao' => '',
    ];

    public $settingsFieldName = 'questao_settings';


    /**
     * Retorna valor de settings com defaults
     *
     * @param  String $value
     * @return Array
     */
    public function getSettingsAttribute($value)
    {
        return array_merge($this->settingsDefaults, json_decode($value, true));
    }

    public static function simNao()
    {
        return [
            'Sim',
            'Não'
        ];
    }

    public static function obterAberto()
    {
        $now = date('Y-m-d H:i:s');
        return Percepcao::where('dataDeAbertura', '<=', $now)->where('dataDeFechamento', '>=', $now)->first();
    }

    public function setDataDeAberturaAttribute($dataDeAbertura)
    {
        $this->attributes['dataDeAbertura'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeAbertura)->toDateTimeString();
    }

    public function setDataDeFechamentoAttribute($dataDeFechamento)
    {
        $this->attributes['dataDeFechamento'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeFechamento)->toDateTimeString();
    }
}
