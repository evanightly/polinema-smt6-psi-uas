<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->randomNumber(2),
            'restock_threshold' => $this->faker->randomNumber(2),
            'min_stock' => $this->faker->randomNumber(2),
            'max_stock' => $this->faker->randomNumber(2),
            'supplier_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
