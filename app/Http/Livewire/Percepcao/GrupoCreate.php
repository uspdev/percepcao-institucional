<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Validation\Validator;
use App\Models\Grupo;

class GrupoCreate extends Component
{
    public $parent_id;
    public $texto;
    public $ativo;
    public $repeticao;
    public $modelo_repeticao;
    public $subGrupos;
    public $optionGrupos;
    public $selectedId;
    public $action;
    protected $rules = [];

    protected $listeners = [
        'getSelectedId',
        'refreshParent' => 'mount',
    ];

    public function mount()
    {
        $this->optionGrupos = [];
        $this->subGrupos = Grupo::with('childGrupos')
            ->get();

        $this->optionGrupos[''] = 'Nenhum';
        foreach ($this->subGrupos as $grupos) {
            $this->optionGrupos[$grupos->id] = $grupos->texto;
        }

        $this->parent_id = '';
        $this->texto = '';
        $this->repeticao = false;
        $this->modelo_repeticao = '';
        $this->ativo = true;
    }

    protected function rules()
    {
        $this->rules = [
            'texto' => 'required',
        ];

        if ($this->repeticao) {
            $this->rules = array_merge($this->rules, [
                'modelo_repeticao' => 'required',
            ]);
        }

        return $this->rules;
    }

    public function save()
    {
        $this->validate();

        $parent_id = (is_numeric($this->parent_id)) ? $this->parent_id : null;

        if ($parent_id) {
            $grupo = Grupo::find($parent_id);

            if ($grupo->repeticao) {
                $this->repeticao = $grupo->repeticao;
                $this->modelo_repeticao = $grupo->modelo_repeticao;
            }
        }

        $created = Grupo::create([
            'parent_id' => $parent_id,
            'texto' => $this->texto,
            'repeticao' => $this->repeticao,
            'modelo_repeticao' => $this->modelo_repeticao,
            'ativo' => $this->ativo,
        ]);

        $this->mount();
    }

    public function getSelectedId($id, $action)
    {
        $this->selectedId = $id;
        $this->action = $action;
    }

    public function delete()
    {
        Grupo::destroy($this->selectedId);

        $this->mount();
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-create')->extends('layouts.app')->section('content');
    }
}
