<?php

namespace App\Services;

use App\Events\TransactionCreated;
use App\Models\Transaction;
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
            throw $e;
        }
    }

    public function delete(Transaction $transaction) {
        if (!$transaction->created_at->isToday()) {
            throw new \Exception('You can only delete transactions that were created today.');
        }

        if ($transaction->hasRelatedModels()) {
            $this->transactionRepository->softDelete($transaction);
        } else {
            $this->transactionRepository->forceDelete($transaction);
        }
    }
}
