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
    public $percepcao;
    public $percepcaoId;

    public function mount()
    {
        $this->questaoClass = new Questao;

        $this->percepcao = Percepcao::find($this->percepcaoId);

        if (isset($this->grupo->parent_id)) {
            $ids = $this->percepcao->settings()->has('grupos.' . $this->grupo->parent_id . '.grupos.' . $this->grupo->id . '.questoes')
            ? array_keys($this->percepcao->settings()->get('grupos.' . $this->grupo->parent_id . '.grupos.' . $this->grupo->id . '.questoes'))
            : [];
        } else {
            $ids = $this->percepcao->settings()->has('grupos.' . $this->grupo->id . '.questoes')
                ? array_keys($this->percepcao->settings()->get('grupos.' . $this->grupo->id . '.questoes'))
                : [];
        }

        $this->grupoQuestaos = Questao::whereIn('id', $ids)
            ->get()
            ->keyBy('id');
        $this->grupoQuestaos = $this->grupoQuestaos->sortKeysUsing(function($key1, $key2) use ($ids) {
            return ((array_search($key1, $ids) > array_search($key2, $ids)) ? 1 : -1);
        });

        $this->questaos = Questao::whereNotIn('id', $ids)->get();
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

    public function getSelectedId($id, $tipoModel, $modelId, $parentId = null)
    {
        $this->emit('getSelectedId', $id, $tipoModel, $modelId, $parentId);
    }

    public function saveSelectedQuestoes($questoes, $grupoId)
    {
        foreach ($questoes as $key => $value) {
            $grupoDetalhe = Grupo::find($grupoId);

            $questaoDetalhe = Questao::find($value['id']);
            if (!is_null($grupoDetalhe->parent_id)) {
                $this->percepcao->settings()->update("grupos.{$grupoDetalhe->parent_id}.grupos.$grupoId.questoes.{$questaoDetalhe->id}", [
                    'id' => $questaoDetalhe->id,
                    'campo' => $questaoDetalhe['campo'],
                ]);
            } else {
                $this->percepcao->settings()->update("grupos.$grupoId.questoes.{$questaoDetalhe->id}", [
                    'id' => $questaoDetalhe->id,
                    'campo' => $questaoDetalhe['campo'],
                ]);
            }
        }

        $this->mount();
    }

    public function updateOrdemQuestao($list, $grupoId)
    {
        $grupoDetalhe = Grupo::find($grupoId);

        !is_null($grupoDetalhe->parent_id)
            ? $this->percepcao->settings()->update("grupos.{$grupoDetalhe->parent_id}.grupos.$grupoId.questoes", '')
            : $this->percepcao->settings()->update("grupos.$grupoId.questoes", '');

        foreach ($list as $key => $value) {
            $questaoDetalhe = Questao::find($value['id']);

            $caminhoGrupo = !is_null($grupoDetalhe->parent_id)
                ? "grupos.{$grupoDetalhe->parent_id}.grupos.$grupoId.questoes.{$value['id']}"
                : "grupos.$grupoId.questoes.{$value['id']}";

            $this->percepcao->settings()->update($caminhoGrupo, [
                'id' => $questaoDetalhe->id,
                'campo' => $questaoDetalhe['campo'],
            ]);
        }

        $this->mount();
    }

    public function canDelete()
    {
        $dataDeAbertura = Percepcao::find($this->percepcaoId)->dataDeAbertura->format('Y-m-d H:i:s');

        return ($dataDeAbertura >= date(now())) ? true : false;
    }

    public function render()
    {
        return view('livewire.percepcao.grupo-questao-show');
    }
}
