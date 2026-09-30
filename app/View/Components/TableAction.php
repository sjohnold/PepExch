<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableAction extends Component
{
    public $route;
    public $text;
    public $icon;
    public $bgColor;
    public $textColor;
    public $hoverShadow;
    public $onclick;

    public function __construct($route = null, $text, $icon = null, $bgColor = '#60363b', $textColor = 'text-white', $hoverShadow = null, $onclick = null)
    {
        $this->route = $route;
        $this->text = $text;
        $this->icon = $icon;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->hoverShadow = $hoverShadow ?? '0 4px 12px rgba(0,0,0,0.2)';
        $this->onclick = $onclick;
    }

    public function render(): View|Closure|string
    {
        return view('components.table-action');
    }
}
