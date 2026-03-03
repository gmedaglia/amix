<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->paragraph(1, false),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 1),
            'stock' => $this->faker->numberBetween(1, 100),
            'depends_on_product_id' => null,
        ];
    }

    public function withoutStock()
    {
        return $this->state(function () {
            return [
                'stock' => 0,
            ];
        });
    }

    public function dependingOnProduct(Product $product)
    {
        return $this->for($product, 'dependable_product');
    }
}
