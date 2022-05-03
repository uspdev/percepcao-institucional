<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Validation\Validator;
use App\Models\Questao;

class QuestaoCreate extends Component
{
    public $campos = [];
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

    public function getUpdatedId($id)
    {
        $this->resetErrorBag();
        $this->updateId = $id;

        $questao = Questao::find($id);
        if ($questao->count()) {
            $this->campos['text'] = $questao->campo['text'];

            $this->campos['type'] = $questao->campo['type'];

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

            if (isset($questao->campo['cols'])) {
                $this->campos['cols'] = $questao->campo['cols'];
            }
            if (isset($questao->campo['rows'])) {
                $this->campos['rows'] = $questao->campo['rows'];
            }
            if (isset($questao->campo['maxlength'])) {
                $this->campos['maxlength'] = $questao->campo['maxlength'];
            }

            $this->selectedField = $questao->campo['type'];

            if (isset($questao->campo['class'])) {
                $this->campos['class'] = $questao->campo['class'];
            }

            $this->ativo = $questao->ativo;

            $this->updating = true;

            $this->emit('gotoUpdate', 'cadastro-questao');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        if (is_numeric($this->updateId)) {
            if ($this->campos['type'] !== 'radio') {
                unset($this->campos['options']);
                $this->campos['options'][] = '';
            }

            Questao::find($this->updateId)->update([
                'campo' => $this->campos,
                'ativo' => $this->ativo,
            ]);

            $this->emit('gotoUpdate', 'questao-' . $this->updateId);
        } else {
            Questao::create([
                'campo' => $this->campos,
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
