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
    public $liberaConsultaMembrosEspeciais;
    public $liberaConsultaDocente;
    public $liberaConsultaAluno;
    public $updateId;
    public $action;

    protected $listeners = [
        'getUpdateId'
    ];

    public function mount()
    {
        $this->semestre = '';
        $this->settings = [];
    }

    public function getUpdateId($updateId, $action)
    {
        $this->resetErrorBag();

        $this->updateId = $updateId;
        $this->action = $action;

        if ($this->action == "create") {
            $this->reset();
            $this->mount();
            $this->dispatchBrowserEvent('openModal');
        } else {
            $update = Percepcao::find($this->updateId);

            $this->ano = $update->ano;
            $this->semestre = $update->semestre;
            $this->dataDeAbertura = $update->dataDeAbertura->format('d/m/Y H:i:s');
            $this->dataDeFechamento = $update->dataDeFechamento->format('d/m/Y H:i:s');
            $this->liberaConsultaMembrosEspeciais = $update->liberaConsultaMembrosEspeciais;
            $this->liberaConsultaDocente = $update->liberaConsultaDocente;
            $this->liberaConsultaAluno = $update->liberaConsultaAluno;
            $this->settings = $update->settings;
        }
    }

    protected function rules()
    {
        $rules = [
            'ano'                               => 'required|digits:4',
            'semestre'                          => 'required|integer',
            'dataDeAbertura'                    => 'required',
            'dataDeFechamento'                  => 'required',
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
        $this->dispatchBrowserEvent('closeModal');
        $this->reset();
    }

    public function render()
    {
        $percepcao = new Percepcao;
        return view('livewire.percepcao.percepcao-create', ['percepcao' => $percepcao,])
            ->extends('layouts.app')->section('content');
    }
}
