<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends Repository {

    public function get(array $options = [], array $searchFields = [], array $relations = []): Builder {
        $query = Product::query();

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

    public function create(array $data): Product {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product {
        $product->update($data);
        return $product->refresh();
    }

    public function softDelete(Product $product): void {
        $product->delete();
    }

    public function forceDelete(Product $product): void {
        $product->forceDelete();
    }
}
