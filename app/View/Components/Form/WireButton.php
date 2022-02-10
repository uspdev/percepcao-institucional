<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class WireButton extends Component
{
    public $class;
    public $label;
    public $click;
    public $wireModifier;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $class = '',
                                $label = '',
                                $click = '',
                                $wireModifier = ''
                            )
    {
        $this->class = $class;
        $this->label = $label;
        $this->click = $click;
        $this->wireModifier = $wireModifier;
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
