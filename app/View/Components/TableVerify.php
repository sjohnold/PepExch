<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableVerify extends Component
{
    /**
     * Create a new component instance.
     */
    public $bgColor;
    public $textColor;
    public $status;

    public function __construct($bgColor, $textColor, $status)
    {
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-verify');
    }
}
