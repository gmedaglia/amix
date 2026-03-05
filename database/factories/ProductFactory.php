<?php

namespace Database\Factories;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends SaleableFactory
{ 
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'stock' => $this->faker->numberBetween(1, 100),
        ]);
    }

    public function withoutStock()
    {
        return $this->state(function () {
            return [
                'stock' => 0,
            ];
        });
    }  
    
    public function withHighStock()
    {
        return $this->state(function () {
            return [
                'stock' => $this->faker->numberBetween(1000, 10000),
            ];
        });
    }    
}
