<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableHeader extends Component
{
    public $title;
    public $subtitle;
    public $icon;

    // Button props (optional)
    public $buttonText;
    public $buttonRoute;
    public $buttonPermission;
    public $buttonIcon;

    // Search props (optional)
    public $showSearch;
    public $searchAction;
    public $searchName;
    public $searchValue;

    public $showPerPage;
    public $showDownload;
    public $downloadRoute;

    public function __construct(
        $title,
        $subtitle = null,
        $icon = null,
        $buttonText = null,
        $buttonRoute = null,
        $buttonPermission = null,
        $buttonIcon = null,
        $showSearch = false,
        $searchAction = null,
        $searchName = 'search',
        $searchValue = null,
        $showPerPage = false,
        $showDownload = false,
        $downloadRoute = null
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;

        $this->buttonText = $buttonText;
        $this->buttonRoute = $buttonRoute;
        $this->buttonPermission = $buttonPermission;
        $this->buttonIcon = $buttonIcon;

        $this->showSearch = $showSearch;
        $this->searchAction = $searchAction ?? url()->current();
        $this->searchName = $searchName;
        $this->searchValue = $searchValue;

        $this->showPerPage = $showPerPage;
        $this->showDownload = $showDownload;
        $this->downloadRoute = $downloadRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-header');
    }
}
