<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireSelect extends Component
{
    public $model;
    public $options;
    public $prepend;
    public $label;
    public $class;
    public $multiple;
    public $placeholder;
    public $wireModifier;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $model = '',
                                $options = [],
                                $prepend = '',
                                $label = '',
                                $class = '',
                                $multiple = false,
                                $placeholder = '',
                                $wireModifier = ''
                            )
    {
        $this->model = $model;
        $this->options = $options;
        $this->prepend = $prepend;
        $this->label = $label;
        $this->class = $class;
        $this->multiple = $multiple;
        $this->placeholder = $placeholder;
        $this->wireModifier = $wireModifier;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-select');
    }
}
