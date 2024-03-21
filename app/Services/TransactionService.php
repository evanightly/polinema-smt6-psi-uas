<?php

namespace App\Services;

use App\Events\TransactionCreated;
use App\Models\Transaction;
use App\Notifications\ProductNeedsRestock;
use App\Repositories\TransactionRepository;
use App\Rules\ProductStockCheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionService {
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository) {
        $this->transactionRepository = $transactionRepository;
    }

    public function isTransactionToday(Transaction $transaction): bool {
        return $transaction->created_at->isToday();
    }

    public function create(array $data) {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate that each product has enough stock
            foreach ($data['products'] as $product) {
                Validator::make($product, [
                    'id' => ['required', new ProductStockCheck($product['id'], $product['quantity'])],
                    'quantity' => ['required', 'integer'],
                ])->validate();
            }

            // Use the repository to store the transaction
            $transaction = $this->transactionRepository->create($data);

            // Attach products to the transaction and set pivot values
            foreach ($data['products'] as $product) {
                $transaction->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price_per_unit' => $product['price_per_unit'],
                    'price_subtotal' => $product['price_subtotal'],
                ]);
            }

            broadcast(new TransactionCreated($transaction));

            // Commit the transaction
            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            // An error occurred; cancel the transaction
            DB::rollback();

            // And throw the error again
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function delete(Transaction $transaction) {
        if ($transaction->hasConstraints()) {
            try {
                DB::beginTransaction();

                // Check if the transaction has any related products
                if ($transaction->products->isNotEmpty()) {
                    // Loop through the products and update their stock
                    foreach ($transaction->products as $product) {
                        $product->stock += $product->pivot->quantity;
                        $product->save();

                        if (!$product->needsRestock()) {
                            DB::table('notifications')
                                ->where('type', ProductNeedsRestock::class)
                                ->where('data->product_id', $product->id)
                                ->where('data->supplier_id', $product->supplier->id)
                                ->where('data->isCompleted', false)
                                ->delete();
                        }
                    }
                }

                $this->transactionRepository->softDelete($transaction);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error($th);
            }
        } else {

            // Rare Occurance
            $this->transactionRepository->forceDelete($transaction);
        }
    }
}
