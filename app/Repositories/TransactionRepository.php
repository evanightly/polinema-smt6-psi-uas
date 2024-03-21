<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository extends Repository {

    public function get(array $options = [], array $searchFields = [], array $relations = []): Builder {
        $query = Transaction::query();

        // Eager load relations if any
        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        // Apply the filters to the query
        if (isset($options['filters'])) {
            $query = $this->applyFilters($query, $options['filters'], $searchFields);
        }

        // Apply sorting to the query
        if (isset($options['sortBy'])) {
            $sortDirection = $options['sortDirection'] ?? 'asc';
            $query = $this->applySorting($query, $options['sortBy'], $sortDirection);
        }
        return $query;
    }

    public function create(array $data): Transaction {
        return Transaction::create($data);
    }

    public function update(Transaction $transaction, array $data): Transaction {
        $transaction->update($data);
        return $transaction->refresh();
    }

    public function softDelete(Transaction $transaction): void {
        $transaction->softDelete();
    }

    public function forceDelete(Transaction $transaction): void {
        $transaction->forceDelete();
    }
}
