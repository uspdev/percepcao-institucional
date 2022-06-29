<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Percepcao;

class GrupoPercepcaoShow extends Component
{
    public $grupos;
    public $percepcaoId = null;

    protected $listeners = [
        'updateOrdem'
    ];

    public function mount($grupos = null)
    {
        if ($grupos !== null) {
            $this->grupos = $grupos;
        } else {
            $percepcao = Percepcao::find($this->percepcaoId);

            $ids = $percepcao->settings()->has('grupos')
                ? array_keys($percepcao->settings()->get('grupos'))
                : [];

            $this->grupos = Grupo::whereNull('parent_id')
                ->whereIn('id', $ids)
                ->with('childGrupos')
                ->get()
                ->keyBy('id');
            $this->grupos = $this->grupos->sortKeysUsing(function($key1, $key2) use ($ids) {
                return ((array_search($key1, $ids) > array_search($key2, $ids)) ? 1 : -1);
            });
        }
    }

    public function updateOrdem($list)
    {
        $percepcao = Percepcao::find($this->percepcaoId);

        $grupos = $percepcao->settings()->get('grupos');

        $percepcao->settings()->delete('grupos');

        foreach ($list as $key => $value) {
            $percepcao->settings()->set("grupos.{$value['id']}", $grupos[$value['id']]);
            $percepcao->settings()->set("grupos.{$value['id']}.ordem", $key + 1);
        }

        $this->mount();
    }

    public function getSelectedId($id, $tipoModel)
    {
        $this->emit('getSelectedId', $id, $tipoModel);
    }

    public function canDelete() {
        $dataDeAbertura = Percepcao::find($this->percepcaoId)->dataDeAbertura->format('Y-m-d H:i:s');

        return ($dataDeAbertura >= date(now())) ? true : false;
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-percepcao-show', [
            'grupos' => $this->grupos,
        ])->extends('layouts.app')->section('content');
    }
}
