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
    public $totalDeAlunosMatriculados;
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
        $this->totalDeAlunosMatriculados = count(Graduacao::listarAtivos());
        $this->settings = [];
    }

    public function getUpdateId($updateId, $action)
    {
        $this->resetErrorBag();

        $this->updateId = $updateId;
        $this->action = $action;

        if($this->action == "create") {
            $this->reset();
            $this->mount();
            $this->dispatchBrowserEvent('openModal');
        }
        else {
            $update = Percepcao::find($this->updateId);

            //dd($update->settings);

            $this->ano = $update->ano;
            $this->semestre = $update->semestre;
            $this->dataDeAbertura = Carbon::parse($update->dataDeAbertura)->format('d/m/Y H:i:s');
            $this->dataDeFechamento = Carbon::parse($update->dataDeFechamento)->format('d/m/Y H:i:s');
            $this->totalDeAlunosMatriculados = $update->totalDeAlunosMatriculados;
            $this->liberaConsultaMembrosEspeciais = $update->liberaConsultaMembrosEspeciais;
            $this->liberaConsultaDocente = $update->liberaConsultaDocente;
            $this->liberaConsultaAluno = $update->liberaConsultaAluno;

            foreach ($update->settings as $key => $value) {
                $this->settings[$key] = $update->settings[$key];
            }
        }
    }

    protected function rules()
    {
        $rules = [
            'ano'                               => 'required|digits:4',
            'semestre'                          => 'required|integer',
            'dataDeAbertura'                    => 'required',
            'dataDeFechamento'                  => 'required',
            'totalDeAlunosMatriculados'         => 'nullable',
            'settings'                          => 'nullable',
        ];

        if($this->action == "update") {
            $rules['liberaConsultaMembrosEspeciais'] = 'required|bool';
            $rules['liberaConsultaDocente'] = 'required|bool';
            $rules['liberaConsultaAluno'] = 'required|bool';
        }

        return $rules;
    }

    public function save()
    {
        $validated = $this->validate();

        if($this->action == "update") {
            Percepcao::find($this->updateId)->update($validated);
        }
        else {
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
        $graduacao = Graduacao::listarAtivos();

        return view('livewire.percepcao.percepcao-create', [
          'percepcao' => $percepcao,
          'graduacao' => $graduacao
        ])->extends('layouts.app')->section('content');
    }
}
