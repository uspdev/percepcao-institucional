<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireRadio extends Component
{
    public $model;
    public $class;
    public $arrValue;
    public $arrText;
    public $id;
    public $wireModifier;
    public $showError;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $model = '',
                                $class = '',
                                $arrValue = [],
                                $arrText = [],
                                $id = '',
                                $wireModifier = '',
                                $showError = true
                            )
    {
        $this->model = $model;
        $this->class = $class;
        $this->arrValue = $arrValue;
        $this->arrText = $arrText;
        $this->id = $id;
        $this->wireModifier = $wireModifier;
        $this->showError = $showError;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-radio');
    }
}
