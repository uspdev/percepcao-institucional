<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Validation\Validator;
use App\Models\Questao;

class QuestaoCreate extends Component
{
    public $campos = [];
    public $estatistica;
    public $ativo;
    public $selectedField;
    public $updating = false;
    public $updateId;

    protected $listeners = [
        'getUpdatedId',
    ];

    public function mount()
    {
        $this->campos = [];
        $this->campos['options'][] = '';

        $this->estatistica = true;

        $this->ativo = true;

        $this->selectedField = '';

        $this->updateId = '';
        $this->updating = false;
    }

    protected function rules()
    {
        $rules = [
            'campos.text' => 'required',
            'campos.type' => 'required',
            'estatistica' => 'required|boolean',
            'ativo' => 'required|boolean',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'campos.text.required' => 'O campo <strong>Título da questão</strong> é obrigatório.',
            'campos.type.required' => 'O campo <strong>Tipo de campo</strong> é obrigatório.',
        ];
    }

    public function addOption()
    {
        $this->campos['options'][] = '';
    }

    public function removeOption($key)
    {
        unset($this->campos['options'][$key]);
    }

    public function getUpdatedId($id, $isCopying = false)
    {
        $this->resetErrorBag();
        $this->updateId = $id;

        $questao = Questao::find($id);
        if ($questao->count()) {
            foreach ($questao->campo as $key => $campo) {
                if ($key !== 'options') {
                    if (isset($questao->campo[$key])) {
                        $this->campos[$key] = $questao->campo[$key];
                    }
                }
            }

            if (!empty($questao->campo['options'][0])) {
                foreach ($questao->campo['options'] as $key => $value) {
                    $this->campos['options'][$key] = [
                        'key' => $value['key'],
                        'value' => $value['value'],
                    ];
                }
            } else {
                unset($this->campos['options']);
                $this->campos['options'][] = '';
            }

            $this->estatistica = $questao->estatistica;

            $this->ativo = $questao->ativo;

            $this->selectedField = $questao->campo['type'];

            if (!$isCopying) {
                $this->updating = true;
            } else {
                $this->updating = false;
            }

            $this->emit('gotoUpdate', 'cadastro-questao');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->campos['type'] !== 'radio') {
            unset($this->campos['options']);
            $this->campos['options'][] = '';
        }

        if ($this->campos['type'] !== 'textarea') {
            unset($this->campos['rows']);
            unset($this->campos['cols']);
            unset($this->campos['maxlength']);
        }

        if ($this->updating) {
            Questao::find($this->updateId)->update([
                'campo' => $this->campos,
                'estatistica' => $this->estatistica,
                'ativo' => $this->ativo,
            ]);

            $this->emit('gotoUpdate', 'questao-' . $this->updateId);
        } else {
            Questao::create([
                'campo' => $this->campos,
                'estatistica' => $this->estatistica,
                'ativo' => $this->ativo,
            ]);
        }

        $this->mount();
    }

    public function cancelUpdate()
    {
        $this->mount();
    }

    public function render()
    {
        return view('livewire.percepcao.questao-create')->extends('layouts.app')->section('content');
    }
}
