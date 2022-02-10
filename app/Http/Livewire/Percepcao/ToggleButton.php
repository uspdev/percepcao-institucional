<?php

namespace App\Http\Livewire\Percepcao;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ToggleButton extends Component
{
    public Model $model;
    public $field;
    public $liberaConsulta;

    protected $listeners = [
      'refreshToggle' => 'mount'
    ];

    public function mount()
    {
        $this->liberaConsulta = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }

    public function render()
    {
        return view('livewire.percepcao.toggle-button');
    }
}
