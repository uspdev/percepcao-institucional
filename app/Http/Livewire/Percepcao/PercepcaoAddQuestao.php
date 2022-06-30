<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Percepcao;
use App\Models\Grupo;

class PercepcaoAddQuestao extends Component
{
    public $percepcao;
    public $grupo;
    public $grupoPercepcao;
    public $grupoCheck;
    public $idPercepcao;
    public $selectedId;
    public $tipoModel;
    public $modelId;
    public $parentId;

    protected $listeners = [
        'getSelectedId',
    ];

    public function mount($idPercepcao = null)
    {
        if (is_numeric($idPercepcao)) {
            $this->percepcao = Percepcao::find($idPercepcao);

            if ($this->percepcao->count()) {
                $ids = $this->percepcao->questaos()->has('grupos') 
                    ? array_keys($this->percepcao->questaos()->get('grupos')) 
                    : [];
                    
                $this->grupo = Grupo::whereNull('parent_id')
                    ->whereNotIn('id', $ids)
                    ->with('childGrupos')
                    ->get();
                
                $this->grupoPercepcao = Grupo::whereNull('parent_id')
                    ->whereIn('id', $ids)
                    ->with('childGrupos')
                    ->get()
                    ->keyBy('id');
                $this->grupoPercepcao = $this->grupoPercepcao->sortKeysUsing(function($key1, $key2) use ($ids) {
                    return ((array_search($key1, $ids) > array_search($key2, $ids)) ? 1 : -1);
                });    
            }
        }
    }

    public function saveSelectedGrupos($grupos)
    {
        $ordem = $this->percepcao->questaos()->has('grupos')
            ? collect($this->percepcao->questaos()->get('grupos'))->max('ordem') + 1
            : 1;

        foreach ($grupos as $key => $value) {
            $grupoDetalhe = Grupo::find($value['id']);

            $this->percepcao->questaos()->update("grupos.{$grupoDetalhe->id}", [
                'id' => $grupoDetalhe->id,
                'ordem' => $ordem,
                'texto' => $grupoDetalhe->texto,
                'repeticao' => $grupoDetalhe->repeticao,
                'modelo_repeticao' => $grupoDetalhe->modelo_repeticao,
            ]);

            if ($grupoDetalhe->grupos->count()) {
                foreach ($grupoDetalhe->grupos as $keyGrupoDetalhe => $grupo) {
                    $this->percepcao->questaos()->update("grupos.{$grupoDetalhe->id}.grupos.{$grupo->id}", [
                        'id' => $grupo->id,
                        'ordem' => $keyGrupoDetalhe,
                        'texto' => $grupo->texto,
                        'repeticao' => $grupo->repeticao,
                        'modelo_repeticao' => $grupo->modelo_repeticao,
                    ]);
                }
            }
        }

        $this->mount($this->percepcao->id);
    }

    public function getSelectedId($id, $tipoModel, $modelId = null, $parentId = null)
    {
        $this->selectedId = $id;
        $this->tipoModel = $tipoModel;
        $this->modelId = $modelId;
        $this->parentId = $parentId;
    }

    public function delete()
    {
        switch ($this->tipoModel) {
            case 'grupo':
                $this->percepcao->questaos()->delete("grupos.{$this->selectedId}");
                break;
            case 'questao':
                !is_null($this->parentId)
                    ? $this->percepcao->questaos()->delete("grupos.{$this->parentId}.grupos.{$this->modelId}.questoes.{$this->selectedId}")
                    : $this->percepcao->questaos()->delete('grupos.' . $this->modelId . '.questoes.' . $this->selectedId);
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
