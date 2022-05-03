<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Percepcao;
use App\Models\Grupo;

class PercepcaoAddQuestao extends Component
{
    public $percepcao;
    public $grupo;
    public $idPercepcao;
    public $selectedId;
    public $tipoModel;
    public $modelId;

    protected $listeners = [
        'getSelectedId',
    ];

    public function mount($idPercepcao = null)
    {
        if (is_numeric($idPercepcao)) {
            $this->percepcao = Percepcao::find($idPercepcao);

            if ($this->percepcao->count()) {
                $this->grupo = Grupo::whereNull('parent_id')
                    ->whereNotIn('id', $this->percepcao->grupos->pluck('id')->toArray())
                    ->with('childGrupos')
                    ->get();
            }
        }
    }

    public function saveSelectedGrupos($grupos)
    {
        foreach ($grupos as $key => $value) {
            if (!$this->percepcao->grupos->count()) {
                $ordem = 0;
            } else {
                $ordem = $this->percepcao->grupos()->max('ordem') + 1;
            }
            $this->percepcao->grupos()->attach($value, ['ordem' => $ordem]);
        }

        $this->mount($this->percepcao->id);
    }

    public function getSelectedId($id, $tipoModel, $modelId = null)
    {
        $this->selectedId = $id;
        $this->tipoModel = $tipoModel;
        $this->modelId = $modelId;
    }

    public function delete()
    {
        switch ($this->tipoModel) {
            case 'grupo':
                $this->percepcao->grupos()->detach($this->selectedId);
                break;
            case 'questao':
                $grupo = Grupo::find($this->modelId);
                $grupo->questaos()->detach($this->selectedId);
                break;
        }

        $this->mount($this->percepcao->id);
    }

    public function render()
    {
        return view('livewire.percepcao.percepcao-add-questao', [
            'percepcao' => $this->percepcao,
            'grupos' => $this->grupo,
        ])->extends('layouts.app')->section('content');
    }
}
