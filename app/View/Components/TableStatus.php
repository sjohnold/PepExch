<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableStatus extends Component
{
    /**
     * Create a new component instance.
     */
    public $status;
    public $className;
    public $icon;
    public function __construct($className, $status, $icon)
    {
        $this->status = $status;
        $this->className = $className;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-status');
    }
}
