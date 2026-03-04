<?php

namespace Database\Factories;

use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends SaleableFactory
{
    public function dependingOnProductStock(Product $product)
    {
        return $this->for($product, 'dependable_product');
    }
}
