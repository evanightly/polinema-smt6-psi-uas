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
        Transaction::factory(10)->create();

        $transactions = Transaction::all();
        $transactions->each(function ($transaction) {
            $products = Product::inRandomOrder()->take(rand(1, 5))->get();
            $products->each(function ($product) use ($transaction) {
                $quantity = rand(1, 10);
                $transaction->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price_per_unit' => $product->price,
                    'price_subtotal' => $product->price * $quantity,
                ]);
            });
        });
    }
}
