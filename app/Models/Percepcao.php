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
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'dataDeAbertura' => 'datetime',
        'dataDeFechamento' => 'datetime',
    ];

    // Valores default da coluna settings
    public $settingsDefaults = [
        'textoAgradecimentoEnvioAvaliacao' => 'Obrigado pela sua participação no processo de avaliação de disciplinas deste semestre.',
        'textoApresentacao' => '',
        'textoFormularioAvaliacao' => '',
        'comentario' => 'Nova percepção',
        'totalDeDisciplinas' => 0,
        'totalDeAlunosMatriculados' => 0,
    ];

    // glorand/laravel-model-settings
    public $settingsFieldName = 'questao_settings';
    public $invokeSettingsBy = 'questaos';
    public $defaultSettings = [];


    /**
     * Retorna valor de settings com defaults
     * 
     * https://laravel.com/docs/8.x/eloquent-mutators#defining-an-accessor
     *
     * @param  String $value
     * @return Array
     */
    public function getSettingsAttribute($value)
    {
        return array_merge($this->settingsDefaults, json_decode($value ?? '{}', true));
    }

    /**
     * Adiciona ou atualiza um valor de settings
     */
    public function addSettings(array $value)
    {
        $this->attributes['settings'] = json_encode(array_merge($this->settings, $value));
    }

    public static function obterAberto()
    {
        $now = date('Y-m-d H:i:s');
        return Percepcao::where('dataDeAbertura', '<=', $now)->where('dataDeFechamento', '>=', $now)->first();
    }

    /**
     * Verifica se uma percepção está abertura
     * 
     * @return Bool
     */
    public function isAberto() {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->lt($now) && $this->dataDeFechamento->gt($now));
    }

    /**
     * Verifica se uma percepção ainda vai ocorrer.
     * 
     * Nessa situação as questões e outros atributos podem ser modificados.
     * Se estiver aberta ou se já passou, não pode.
     * 
     * @return Bool
     */
    public function isFuturo() {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->gt($now) && $this->dataDeFechamento->gt($now));
    }

    public function isFinalizado() {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->lt($now) && $this->dataDeFechamento->lt($now));
    }

    /**
     * https://laravel.com/docs/8.x/eloquent-mutators#defining-a-mutator
     */
    public function setDataDeAberturaAttribute($dataDeAbertura)
    {
        $this->attributes['dataDeAbertura'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeAbertura)->toDateTimeString();
    }

    public function setDataDeFechamentoAttribute($dataDeFechamento)
    {
        $this->attributes['dataDeFechamento'] = Carbon::createFromFormat('d/m/Y H:i:s', $dataDeFechamento)->toDateTimeString();
    }

    /**
     * Relacionamento 1:N com disciplinas
     */
    public function disciplinas()
    {
        return $this->hasMany('App\Models\Disciplina');
    }
}
