<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Questao;
use App\Models\Percepcao;
use App\Models\Grupo;

class GrupoQuestaoShow extends Component
{
    public $questaos;
    public $questao = [];
    public $questaoClass;
    public $grupoQuestaos;
    public $grupo;
    public $percepcaoId;

    public function mount(Questao $questaoClass = null)
    {
        $this->questaoClass = $questaoClass;

        $this->grupoQuestaos = $this->grupo->questaos()->get();

        $this->questaos = Questao::whereNotIn('id', $this->grupo->questaos()->pluck('id')->toArray())->get();
    }

    public function getTituloQuestao($id)
    {
        $questao = Questao::find($id);

        $titulo = $questao['campo']['text'] . ' (Tipo: ' . $questao['campo']['type'];

        $questaoPlucked = $questao->where('id', $id)->get()->pluck('campo.options')->toArray();

        if (!empty($questaoPlucked[0][0])) {
            $values = implode(', ', array_column($questaoPlucked[0], 'value'));
            $titulo .= ', Opções: ' . $values;
        }

        $titulo .=  ')';

        return $titulo;
    }

    public function getSelectedId($id, $tipoModel, $modelId)
    {
        $this->emit('getSelectedId', $id, $tipoModel, $modelId);
    }

    public function saveSelectedQuestoes($questoes, $grupoId)
    {
        $grupo = Grupo::find($grupoId);

        foreach ($questoes as $key => $questao) {
            if (!$grupo->questaos->count()) {
                $ordem = 0;
            } else {
                $ordem = $grupo->questaos()->max('ordem') + 1;
            }

            $grupo->questaos()->attach($questao, ['ordem' => $ordem]);
        }

        $this->mount();
    }

    public function updateOrdemQuestao($list, $grupoId)
    {
        $grupo = Grupo::find($grupoId);

        foreach ($list as $key => $value) {
            $grupo->questaos()->updateExistingPivot($value['id'], [
                'ordem' => $key,
            ]);
        }

        $this->mount();
    }

    public function canDelete()
    {
        $dataDeAbertura = Percepcao::find($this->percepcaoId)->first()->dataDeAbertura->format('Y-m-d H:i:s');

        return ($dataDeAbertura >= date(now())) ? true : false;
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-questao-show');
    }
}
