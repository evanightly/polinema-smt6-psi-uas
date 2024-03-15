<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;

class SupplierRepository extends Repository {

    public function get(array $options = [], array $searchFields = [], array $relations = []): Builder {
        $query = Supplier::query();

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

    public function create(array $data): Supplier {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier {
        $supplier->update($data);
        return $supplier->refresh();
    }

    public function delete(Supplier $supplier): Supplier {
        $supplier->delete();
        return $supplier;
    }
}
