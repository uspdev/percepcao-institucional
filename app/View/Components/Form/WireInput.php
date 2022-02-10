<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireInput extends Component
{
    public $model;
    public $prepend;
    public $label;
    public $class;
    public $type;
    public $id;
    public $wireModifier;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $model = '',
                                $prepend = '',
                                $label = '',
                                $class = '',
                                $type = 'text',
                                $id = '',
                                $wireModifier = ''
                            )
    {
        $this->model = $model;
        $this->prepend = $prepend;
        $this->label = $label;
        $this->class = $class;
        $this->type = $type;
        $this->id = mt_rand(1000000, 9999999);
        $this->wireModifier = $wireModifier;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-input');
    }
}
