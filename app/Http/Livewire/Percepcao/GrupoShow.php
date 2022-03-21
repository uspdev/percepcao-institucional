<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;

class GrupoShow extends Component
{
    public $grupos;

    protected $listeners = [
        'refreshParent' => 'mount',
        'updateOrder',
    ];

    public function mount()
    {
        $this->grupos = Grupo::whereNull('parent_id')
            ->with('childGrupos')
            ->get();
    }

    public function updateOrder($list) {        
        $this->reorder($list);
        $this->mount();        
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function reorder($list)
    {
        foreach ($list as $key => $value) {                        
            if ($value['parent'] === null) {
                Grupo::find($value['id'])->update(['parent_id' => $value['parent']]);
            }            
            if (!empty($value['children'])) {
                foreach ($value['children'] as $keyItem => $valueItem) {
                    Grupo::find($valueItem['id'])->update(['parent_id' => $value['id']]);                    
                }                
                $this->reorder($value['children']);                               
            }
        }
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-show', [
            'grupos' => $this->grupos,
        ])->extends('layouts.app')->section('content');
    }
}
