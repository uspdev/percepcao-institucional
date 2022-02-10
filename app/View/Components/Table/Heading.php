<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Heading extends Component
{
    public $column;
    public $sortable;
    public $sortField;
    public $direction;
    public $text;
    public $customAttributes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
                                $column = '',
                                $sortable = null,
                                $sortField = null,
                                $direction = null,
                                $text = '',
                                $customAttributes = []
                            )
    {
        $this->column = $column;
        $this->sortable = $sortable;
        $this->sortField = $sortField;
        $this->direction = $direction;
        $this->text = $text;
        $this->customAttributes = $customAttributes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.heading');
    }
}
