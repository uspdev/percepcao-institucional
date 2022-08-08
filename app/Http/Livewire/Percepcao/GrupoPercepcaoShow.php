<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Percepcao;

class GrupoPercepcaoShow extends Component
{
    public $grupos;

    // Adicionado em 1/7/2022 para acomodar isFuturo()
    public $percepcao;
    public $percepcaoId = null;

    protected $listeners = [
        'updateOrdem'
    ];

    public function mount($grupos = null)
    {
        $percepcao = Percepcao::find($this->percepcaoId);
        $this->percepcao = $percepcao;

        if ($grupos !== null) {
            $this->grupos = $grupos;
        } else {
            $ids = $percepcao->questaos()->has('grupos')
                ? array_keys($percepcao->questaos()->get('grupos'))
                : [];

            $this->grupos = Grupo::whereNull('parent_id')
                ->whereIn('id', $ids)
                ->with('childGrupos')
                ->get()
                ->keyBy('id');
            $this->grupos = $this->grupos->sortKeysUsing(function ($key1, $key2) use ($ids) {
                return ((array_search($key1, $ids) > array_search($key2, $ids)) ? 1 : -1);
            });
        }
    }

    public function updateOrdem($list)
    {
        $percepcao = Percepcao::find($this->percepcaoId);
        $this->percepcao = $percepcao;

        $grupos = $percepcao->questaos()->get('grupos');

        $percepcao->questaos()->delete('grupos');

        foreach ($list as $key => $value) {
            $percepcao->questaos()->set("grupos.{$value['id']}", $grupos[$value['id']]);
            $percepcao->questaos()->set("grupos.{$value['id']}.ordem", $key + 1);
        }

        $this->mount();
    }

    public function getSelectedId($id, $tipoModel)
    {
        $this->emit('getSelectedId', $id, $tipoModel);
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-percepcao-show', ['grupos' => $this->grupos,])
            ->extends('layouts.app')->section('content');
    }
}
