<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireButton extends Component
{
    public $class;
    public $classIcon;
    public $label;
    public $click;
    public $wireModifier;
    public $action;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $class = '',
                                $classIcon = '',
                                $label = '',
                                $click = '',
                                $wireModifier = '',
                                $action = ''
                            )
    {
        $this->class = $class;
        $this->classIcon = $classIcon;
        $this->label = $label;
        $this->click = $click;
        $this->wireModifier = $wireModifier;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.wire-button');
    }
}
