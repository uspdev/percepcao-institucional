<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;

class GrupoShow extends Component
{
    public $grupos;
    public $texto;
    public $selectedId;
    public $action;

    protected $listeners = [
        'updateOrder'
    ];

    public function mount()
    {
        $this->grupos = Grupo::whereNull('parent_id')
            ->with('childGrupos')
            ->get();
        
        $this->isEditing = false;
        $this->editTextId = null;
    }

    public function updateOrder($list)
    {
        foreach ($list as $key => $value) {
            if ($value['parent'] === null) {
                Grupo::find($value['id'])->update(['parent_id' => $value['parent']]);
            }
            if (!empty($value['children'])) {
                foreach ($value['children'] as $keyItem => $valueItem) {
                    Grupo::find($valueItem['id'])->update(['parent_id' => $value['id']]);
                }
                $this->updateOrder($value['children'], true);
            }
        }

        $this->mount();
    }

    public function updateTexto($id, $texto)
    {        
        Grupo::find($id)->update(['texto' => $texto]);

        $this->mount();
        $this->emit('refreshParent');
    }

    public function getSelectedId($id, $action)
    {
        $this->emit('getSelectedId', $id, $action);
    }


    public function render()
    {
        return view('livewire.percepcao.grupo-show', [
            'grupos' => $this->grupos,
        ])->extends('layouts.app')->section('content');
    }
}
