<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Percepcao;
use App\Models\Questao;

class GrupoPercepcaoShow extends Component
{
    public $grupos;
    public $percepcaoId = null;

    protected $listeners = [
        'updateOrdem'
    ];

    public function mount($grupos = null, $grupoId = null)
    {
        if ($grupos !== null) {
            $this->grupos = $grupos;
        } else {
            $this->grupos = Grupo::whereNull('parent_id')
                ->with('childGrupos')
                ->get();
        }

        if ($grupoId) {
            $this->grupoQuestao = Questao::whereNotIn('id', $this->percepcao->grupos->pluck('id')->toArray())
                ->with('childGrupos')
                ->get();
        }
    }

    public function updateOrdem($list)
    {
        $percepcao = Percepcao::find($this->percepcaoId);

        foreach ($list as $key => $value) {
            $percepcao->grupos()->updateExistingPivot($value['id'], [
                'ordem' => $key,
            ]);
        }

        $this->mount($percepcao->grupos);
    }

    public function getSelectedId($id, $tipoModel)
    {
        $this->emit('getSelectedId', $id, $tipoModel);
    }

    public function canDelete() {
        $dataDeAbertura = Percepcao::find($this->percepcaoId)->first()->dataDeAbertura->format('Y-m-d H:i:s');

        return ($dataDeAbertura >= date(now())) ? true : false;
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-percepcao-show', [
            'grupos' => $this->grupos,
        ])->extends('layouts.app')->section('content');
    }
}
