<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $years = [2024, 2023, 2025];
        foreach ($years as $year) {
            for ($month = 1; $month <= 12; $month++) {
                $transactionCount = rand(10, 20);
                for ($i = 0; $i < $transactionCount; $i++) {
                    $transaction = Transaction::factory()->create([
                        'created_at' => date('Y-m-d H:i:s', strtotime("$year-$month-1 +$i days"))
                    ]);

                    $products = Product::inRandomOrder()->take(rand(1, 5))->get();
                    $products->each(function ($product) use ($transaction) {
                        $quantity = rand(1, 10);
                        $transaction->products()->attach($product->id, [
                            'quantity' => $quantity,
                            'price_per_unit' => $product->price,
                            'price_subtotal' => $product->price * $quantity,
                        ]);
                    });
                }
            }
        }
    }
}
