<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ajaxForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $route;
    public $method;
    public $id;
    public $inputs;
    public $selects;
    public $gg;
    public function __construct($route = "", $method = 'POST', $id, $inputs, $selects = [], $gg = "")
    {
        $this->route = $route;
        $this->method = $method;
        $this->id = $id;
        $this->inputs = $inputs;
        $this->selects = $selects;
        $this->gg = $gg;
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.ajax-form');
    }
}
