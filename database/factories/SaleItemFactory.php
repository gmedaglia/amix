<?php

namespace Database\Factories;

use App\Enums\ItemType;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleItem>
 */
class SaleItemFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 20),
        ];
    }

    public function product(Product $product)
    {
        return $this->state(function() use ($product) {
            return [
                'saleable_id' => $product->id,
                'saleable_type' => ItemType::Product->className(),
                'unit_price' => $product->price,
            ];
        });
    }

    public function service(Service $service)
    {
        return $this->state(function() use ($service) {
            return [
                'saleable_id' => $service->id,
                'saleable_type' => ItemType::Service->className(),
                'unit_price' => $service->price,
            ];
        });
    }    
}
