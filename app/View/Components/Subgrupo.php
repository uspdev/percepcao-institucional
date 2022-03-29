<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Subgrupo extends Component
{
    public $principal;
    public $childGrupos;
    public $subgrupo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $principal = true,
                                $childGrupos = '',
                                $subgrupo = ''
                            )
    {
        $this->principal = $principal;
        $this->childGrupos = $childGrupos;
        $this->subgrupo = $subgrupo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subgrupo');
    }
}
