<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository {

    /**
     * Applies the given filters to the query.
     *
     * This method iterates over each filter and applies it to the query. If the filter is 'search',
     * it applies a 'like' condition on the 'name' field. If the filter value is an array, it applies
     * a 'whereIn' condition. Otherwise, it applies a 'where' condition.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query to apply the filters to.
     * @param array $filters The filters to apply. Each key is a field name and each value is the filter value.
     * @return \Illuminate\Database\Eloquent\Builder The query with the filters applied.
     */
    private function applyFilters(Builder $query, array $filters): Builder {
        foreach ($filters as $field => $value) {
            if ($field === 'search') {
                $query->where('name', 'like', '%' . $value . '%');
            } elseif (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    /**
     * Applies sorting to the query.
     *
     * This method applies an 'orderBy' condition to the query if a sort field is provided.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query to apply the sorting to.
     * @param string|null $sortBy The field to sort by. If null, no sorting is applied.
     * @param string $sortDirection The direction to sort in. Can be 'asc' or 'desc'.
     * @return \Illuminate\Database\Eloquent\Builder The query with the sorting applied.
     */
    private function applySorting(Builder $query, string|null $sortBy, string $sortDirection): Builder {
        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query;
    }

    public function get(array $options = []): Builder {
        $defaultOptions = [
            'relations' => ['supplier', 'transactions'],
            'filters' => [],
            'sortBy' => null,
            'sortDirection' => 'asc'
        ];

        $options = array_merge($defaultOptions, $options);

        $query = Product::with($options['relations']);

        $query = $this->applyFilters($query, $options['filters']);
        $query = $this->applySorting($query, $options['sortBy'], $options['sortDirection']);

        return $query;
    }

    public function create(array $data): Product {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product {
        $product->update($data);
        return $product->refresh();
    }

    public function delete(Product $product): void {
        $product->delete();
    }
}
