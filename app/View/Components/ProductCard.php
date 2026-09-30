<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component
{
    public $product;
    public $wishlistIds;

    public function __construct($product, $wishlistIds = [])
    {
        $this->product = $product;
        $this->wishlistIds = $wishlistIds;
    }

    public function render()
    {
        return view('components.product-card');
    }
}
