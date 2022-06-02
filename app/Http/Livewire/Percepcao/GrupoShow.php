<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Percepcao;
use Illuminate\Support\Facades\DB;

class GrupoShow extends Component
{
    public $grupos;
    public $texto;
    public $selectedId;
    public $action;

    protected $listeners = [
        'updateOrdem'
    ];

    public function mount()
    {
        $this->grupos = Grupo::whereNull('parent_id')
            ->with('childGrupos')
            ->get();
    }

    public function updateOrdem($list)
    {                
        foreach ($list as $key => $value) {
            if ($value['parent'] === null) {
                Grupo::find($value['id'])->update(['parent_id' => $value['parent']]);
            }
            if (!empty($value['children'])) {
                foreach ($value['children'] as $keyItem => $valueItem) {
                    Grupo::find($valueItem['id'])->update(['parent_id' => $value['id']]);
                }
                $this->updateOrdem($value['children'], true);
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

    public function canDelete($grupoId)
    {
        $percepcoes = Percepcao::get();

        $canDelete = true;

        foreach ($percepcoes as $percepcao) {
            if ($percepcao->settings()->has("grupos.$grupoId")) {
                $canDelete = false;
                break;
            } else {
                $canDelete = true;
            }
        }
        return $canDelete;
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-show', [
            'grupos' => $this->grupos,
        ])->extends('layouts.app')->section('content');
    }
}
