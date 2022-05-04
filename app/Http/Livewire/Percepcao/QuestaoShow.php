<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Questao;

class QuestaoShow extends Component
{
    public $questao;
    public $questaos;
    public $selectedId;

    public function mount()
    {
        $this->questaos = Questao::get();
    }

    public function getSelectedId($id)
    {
        $this->selectedId = $id;
    }

    public function getUpdateId($id)
    {
        $this->emit('getUpdatedId', $id);
    }

    public function hasGrupo($id)
    {
        return Questao::find($id)->grupos->count();
    }

    public function copyQuestao($id)
    {
        $this->emit('getUpdatedId', $id, true);
    }

    public function delete()
    {
        Questao::destroy($this->selectedId);

        $this->mount();
    }

    public function render()
    {
        return view('livewire.percepcao.questao-show');
    }
}
