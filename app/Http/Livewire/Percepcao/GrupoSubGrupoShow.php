<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;

class GrupoSubGrupoShow extends Component
{    
    public $childGrupos;
    public $subgrupo;
    public $principal;

    protected $listeners = [
        'refreshChild' => '$refresh',
    ];

    public function updateSubgroupOrder($list)
    {
        foreach($list as $key => $value) {            
            if (!empty($value['items'])) {
                foreach ($value['items'] as $keyItem => $valueItem) {
                    if ($valueItem['value'] == $value['value']) {
                        $temp[$key.$keyItem] = [
                            'pai' => null,
                            'filho' => $value['value']
                        ];

                        Grupo::find($valueItem['value'])->update(['parent_id' => null]);
                    }
                    else {
                        $temp[$key.$keyItem] = [
                            'pai' => $value['value'],
                            'filho' => $valueItem['value']
                        ];

                        Grupo::find($valueItem['value'])->update(['parent_id' => $value['value']]);
                    }
                }
                               
            }
        }

        dd($list);
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-sub-grupo-show', [
            'childGrupos' => $this->childGrupos,
            'subgrupo' => $this->subgrupo,
            'principal' => $this->principal,
        ]);
    }
}
