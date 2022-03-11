<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $class;
    public $id;
    public $title;
    public function __construct($class = "", $id = "", $title = "")
    {
        $this->class = $class;
        $this->id = $id;
        $this->title = $title;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.card');
    }
}
