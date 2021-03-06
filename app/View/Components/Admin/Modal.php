<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $type;
    public $btn;
    public $id;

    public function __construct($title, $type = "primary", $btn, $id)
    {
        $this->title = $title;
        $this->type = $type;
        $this->btn = $btn;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.modal');
    }
}
