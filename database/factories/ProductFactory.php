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
            'name' => $this->faker->firstNameFemale(),
            'description' => $this->faker->text(200),
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->randomNumber(2),
            'restock_threshold' => $this->faker->randomNumber(2),
        ];
    }
}
