<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Percepcao;
use Uspdev\Replicado\Graduacao;
use Carbon\Carbon;

class PercepcaoCreate extends Component
{
    public $ano;
    public $semestre;
    public $dataDeAbertura;
    public $dataDeFechamento;
    public $settings = [];
    public $questao_settings = [];
    public $liberaConsultaMembrosEspeciais;
    public $liberaConsultaDocente;
    public $liberaConsultaAluno;
    public $updateId;
    public $action;
    public $titulo;

    protected $listeners = [
        'getUpdateId'
    ];

    public function mount()
    {
        $this->semestre = '';

        $this->settings = [];

        $this->titulo = 'Cadastro';

        if ($this->action === 'create') {
            $this->titulo = 'Cadastro';
        }

        if ($this->action === 'update') {
            $this->titulo = 'Alteração';
        }

        if ($this->action === 'copy') {
            $this->titulo = 'Cópia';
        }
    }

    public function getUpdateId($updateId, $action)
    {
        $this->resetErrorBag();

        $this->updateId = $updateId;
        $this->action = $action;

        if ($this->action == 'create') {
            $this->reset();
            $this->mount();
        } else {
            $update = Percepcao::find($this->updateId);

            $this->ano = $update->ano;
            $this->semestre = $update->semestre;
            $this->dataDeAbertura = $update->dataDeAbertura->format('d/m/Y H:i:s');
            $this->dataDeFechamento = $update->dataDeFechamento->format('d/m/Y H:i:s');
            if ($this->action != 'copy') {
                $this->liberaConsultaMembrosEspeciais = $update->liberaConsultaMembrosEspeciais;
                $this->liberaConsultaDocente = $update->liberaConsultaDocente;
                $this->liberaConsultaAluno = $update->liberaConsultaAluno;
            }

            $this->questao_settings = $update->questao_settings;

            $this->settings = $update->settings;
        }
    }

    public function cancelAction()
    {
        $this->emit('cancelAction');
    }

    protected function rules()
    {
        $rules = [
            'ano'                               => 'required|digits:4',
            'semestre'                          => 'required|integer',
            'dataDeAbertura'                    => 'required',
            'dataDeFechamento'                  => 'required',
            'questao_settings'                          => 'nullable',
            'settings'                          => 'nullable',
        ];

        if ($this->action == 'update') {
            $rules['liberaConsultaMembrosEspeciais'] = 'required|bool';
            $rules['liberaConsultaDocente'] = 'required|bool';
            $rules['liberaConsultaAluno'] = 'required|bool';
        }

        return $rules;
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->action == 'update') {
            Percepcao::find($this->updateId)->update($validated);
        } else {
            Percepcao::create($validated);
        }

        $this->emit('refreshParent');
        $this->emit('refreshToggle');
        $this->emit('cancelAction');
        $this->reset();
    }

    public function render()
    {
        $percepcao = new Percepcao;
        return view('livewire.percepcao.percepcao-create', ['percepcao' => $percepcao,])
            ->extends('layouts.app')->section('content');
    }
}
