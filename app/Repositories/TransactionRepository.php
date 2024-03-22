<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        $transaction->delete();
    }

    public function forceDelete(Transaction $transaction): void {
        $transaction->forceDelete();
    }

    /**
     * Chart API
     */

    public function getTransactionYears() {
        return Transaction::selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year');
    }
    public function getTransactionsByYear($year) {
        $transactions = Transaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(price_total) as total')
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($transaction) use ($year) {
                $transaction->transaction_date = date('F, Y', mktime(0, 0, 0, $transaction->month, 1, $year));
                return $transaction;
            });

        return response()->json($transactions);
    }
}
