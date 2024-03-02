<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'user_id' => 1, // Rendra(Staff)
            'buyer_name' => $this->faker->name(),
            'price_total' => $this->faker->randomFloat(2, 10, 1000),
            'transaction_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
