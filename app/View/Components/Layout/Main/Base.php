<?php

namespace App\View\Components\Layout\Main;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Base extends Component
{
    /**
     * Create a new component instance.
     */
    public $metaData;
    public function __construct($metaData=null)
    {
        $this->metaData=$metaData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.main.base');
    }
}
