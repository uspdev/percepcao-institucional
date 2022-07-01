<?php

namespace App\Http\Livewire\Questao;

use Livewire\Component;
use App\Models\Questao;
use App\Models\Percepcao;

class Show extends Component
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

    public function canDelete($questaoId)
    {
        $percepcoes = Percepcao::get();

        foreach ($percepcoes as $percepcao) {
            if ($percepcao->questaos()->has("grupos")) {
                $canDelete = $this->verificaQuestaoSettings($percepcao->questaos()->get("grupos"), $questaoId);
                if (!$canDelete) {
                    return false;
                }
            } else {
                return true;
            }
        }

        return true;
    }

    public function verificaQuestaoSettings($settings, $questaoId, $bla = null)
    {
        $canDelete = true;

        foreach ($settings as $key => $value) {
            if (isset($value["questoes"][$questaoId])) {
                $canDelete = false;
                break;
            } else {  
                if (isset($value["grupos"])) {
                    foreach ($value["grupos"] as $key2 => $value2) {
                        if (isset($value2["questoes"][$questaoId])) {
                            $canDelete = false;
                            break;
                        } else {
                            $canDelete = true;
                        }
                    }
                } else {
                    $canDelete = true;
                }
            }
        }

        return $canDelete;
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
        return view('livewire.questao.show');
    }
}
