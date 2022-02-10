<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireTextarea extends Component
{
    public $model;
    public $prepend;
    public $append;
    public $label;
    public $class;
    public $id;
    public $wireModifier;
    public $xData;
    public $dataLimit;
    public $showError;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $model = '',
                                $prepend = '',
                                $append = '',
                                $label = '',
                                $class = '',
                                $id = '',
                                $wireModifier = '',
                                $xData = '',
                                $dataLimit = '',
                                $showError = true
                            )
    {
        $this->model = $model;
        $this->prepend = $prepend;
        $this->append = $append;
        $this->label = $label;
        $this->class = $class;
        $this->id = mt_rand(1000000, 1999999);
        $this->wireModifier = $wireModifier;
        $this->xData = $xData;
        $this->dataLimit = $dataLimit;
        $this->showError = $showError;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-textarea');
    }
}
