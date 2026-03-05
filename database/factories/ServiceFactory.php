<?php

namespace Database\Factories;

use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends SaleableFactory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'available' => true,
        ]);
    }

    public function dependingOnProductStock(Product $product)
    {
        return $this->for($product, 'dependable_product');
    }
}
