<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireDatetimepicker extends Component
{
    public $model;
    public $prepend;
    public $label;
    public $class;
    public $wireModifier;
    public $endDate;
    public $modelEndDate;
    public $labelEndDate;
    public $prependEndDate;
    public $dateTimeFormat;

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
                                $wireModifier = '',
                                $endDate = false,
                                $modelEndDate = '',
                                $labelEndDate = '',
                                $prependEndDate = '',
                                $dateTimeFormat = 'DD/MM/YYYY HH:mm:ss'
                            )
    {
        $this->model = $model;
        $this->prepend = $prepend;
        $this->label = $label;
        $this->class = $class;
        $this->wireModifier = $wireModifier;
        $this->endDate = $endDate;
        $this->modelEndDate = $modelEndDate;
        $this->labelEndDate = $labelEndDate;
        $this->prependEndDate = $prependEndDate;
        $this->dateTimeFormat = $dateTimeFormat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-datetimepicker');
    }
}
