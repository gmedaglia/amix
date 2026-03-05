<?php

namespace App\Exceptions;

use App\Models\Product;

class ProductSellQuotaExceededException extends SaleCreationException
{
    public function __construct(Product $product)
    {
        return parent::__construct("Product \"{$product->name}\" already sold 3 times to client today.", 5000);
    }
}
