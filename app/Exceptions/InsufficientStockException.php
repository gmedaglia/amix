<?php

namespace App\Exceptions;

use App\Models\Product;

class InsufficientStockException extends SaleCreationException
{
    public function __construct(Product $product)
    {
        return parent::__construct("Insufficient stock for product \"{$product->name}\".", 4000);
    }
}
