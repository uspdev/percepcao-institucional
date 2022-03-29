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
    public $subGrupos;
    public $optionGrupos;
    public $selectedId;
    public $action;

    protected $listeners = [
        'getSelectedId'
    ];

    public function mount()
    {
        $this->subGrupos = Grupo::with('childGrupos')
            ->get();

        $this->optionGrupos[''] = 'Nenhum';
        foreach ($this->subGrupos as $grupos) {
            $this->optionGrupos[$grupos->id] = $grupos->texto;
        }
        
        $this->parent_id = '';
        $this->texto = '';
        $this->ativo = true;
    }

    protected $rules = [
        'texto' => 'required',
    ];

    public function save()
    {
        $this->validate();

        $parent_id = (is_numeric($this->parent_id)) ? $this->parent_id : null;

        $created = Grupo::create([
            'parent_id' => $parent_id,
            'texto' => $this->texto,
            'ativo' => $this->ativo,
        ]);
        
        $this->texto = '';
        $this->parent_id = '';
    }

    public function getSelectedId($id, $action)
    {
        $this->selectedId = $id;
        $this->action = $action;        
    }

    public function delete()
    {
        Grupo::destroy($this->selectedId);
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-create')->extends('layouts.app')->section('content');
    }
}
