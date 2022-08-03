<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Resposta;
use Uspdev\Replicado\Graduacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Glorand\Model\Settings\Traits\HasSettingsField;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percepcao extends Model
{
    use HasFactory, HasSettingsField, SoftDeletes;

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
        'nome' => 'Nova percepção',
        'totalDeDisciplinas' => 0,
        'totalDeAlunosMatriculados' => 0,
        'membrosEspeciais' => [],
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

    /**
     * Retorna uma percepção que esteja no período de avaliação
     * 
     * Caso $proximo = true, retorna também se estiver no período entre preview e posview.
     * 
     * @param Bool $proximo
     * @return \App\Models\Percepcao 
     */
    public static function obterAberto($proximo = false)
    {
        if ($proximo == true) {
            $percepcao = Percepcao::where('dataDeAbertura', '<=', now()->addDays(config('percepcao.preview')))
                ->where('dataDeFechamento', '>=', now()->subDays(config('percepcao.posview')))
                ->first();
        } else {
            $percepcao = Percepcao::where('dataDeAbertura', '<=', now())->where('dataDeFechamento', '>=', now())->first();
        }

        return $percepcao;
    }

    /**
     * Verifica se uma percepção está abertura
     * 
     * @return Bool
     */
    public function isAberto()
    {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->lt($now) && $this->dataDeFechamento->gt($now));
    }

    /**
     * Verifica se uma percepção está nos dias que antecedem a abertura
     * 
     * @return Bool
     */
    public function isPreview()
    {
        return ($this->dataDeAbertura->gt(now()) &&
            $this->dataDeAbertura->lt(now()->addDays(config('percepcao.preview')))
        );
    }

    /**
     * Verifica se uma percepção está nos dias após o fechamento mostrando mensagem
     * 
     * @return Bool
     */
    public function isPosview()
    {
        return ($this->dataDeFechamento->lt(now()) &&
            $this->dataDeFechamento->gt(now()->subDays(config('percepcao.posview')))
        );
    }

    /**
     * Verifica se uma percepção ainda vai ocorrer.
     * 
     * Nessa situação as questões e outros atributos podem ser modificados.
     * Se estiver aberta ou se já passou, não pode.
     * 
     * @return Bool
     */
    public function isFuturo()
    {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->gt($now) && $this->dataDeFechamento->gt($now));
    }

    public function isFinalizado()
    {
        $now = date('Y-m-d H:i:s');
        return ($this->dataDeAbertura->lt($now) && $this->dataDeFechamento->lt($now));
    }

    /**
     * Verifica se o aluno já respondeu ao questionário
     * 
     * @param Int $codpes - Nro USP do aluno (opcional). Se não informado pega do usuário logado.
     * @return Array lista de respostas
     */
    public function isRespondido($codpes = null)
    {
        if (is_null($codpes)) {
            $user = Auth::user();
        } else {
            $user = User::where('codpes', $codpes)->first();
        }
        return Resposta::where('percepcao_id', $this->id)->where('user_id', $user->id)->first();
    }

    /**
     * Lista as disciplinas da percepção para um dado $codpes
     * 
     * @param Int $codpes - Nro USP do aluno (opcional). Se não informado pega do usuário logado.
     * @return Array
     */
    public function listarDisciplinasAluno($codpes = null)
    {
        $codpes = is_null($codpes) ? Auth::user()->codpes : $codpes;
        return Graduacao::listarDisciplinasAlunoAnoSemestre($codpes, $this->ano . $this->semestre);
    }

    /**
     * Conta o número de alunos que responderam a determinada Percepção
     * 
     * @return Int
     */
    public function contarRespostas()
    {
        return $this->respostas()->distinct('codpes')->count();
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

    /**
     * Relacionamento com respostas
     */
    public function respostas()
    {
        return $this->hasMany('App\Models\Resposta');
    }
}
