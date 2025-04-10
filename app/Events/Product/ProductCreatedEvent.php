<?php

namespace App\Events\Product;

use Illuminate\Foundation\Events\Dispatchable;

class ProductCreatedEvent
{
    use Dispatchable;

    public $product;
    public function __construct(array $product)
    {
        $this->product = $product;
    }
}
