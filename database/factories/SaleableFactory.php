<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saleable>
 */
abstract class SaleableFactory extends Factory
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
    
    public function withHighStock()
    {
        return $this->state(function () {
            return [
                'stock' => $this->faker->numberBetween(1000, 10000),
            ];
        });
    }      
}
