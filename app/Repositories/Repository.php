<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Repository {
    /**
     * Applies the given filters to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query to apply the filters to.
     * @param array $filters The filters to apply.
     * @param array $searchFields The fields to be searched when the 'search' filter is used.
     * @return \Illuminate\Database\Eloquent\Builder The query with the filters applied.
     */
    protected function applyFilters(Builder $query, array $filters, array $searchFields): Builder {
        // Loop through each filter
        foreach ($filters as $field => $value) {
            // If the filter is 'search', use a LIKE query to search the specified fields
            if ($field === 'search' && $searchFields) {
                $query->where(function ($query) use ($value, $searchFields) {
                    // Loop through each search field
                    foreach ($searchFields as $searchField) {
                        // Add a LIKE condition for the current search field
                        $query->orWhere($searchField, 'like', '%' . $value . '%');
                    }
                });
            }
            // If the filter value is an array, use a WHERE IN query
            elseif (is_array($value)) {
                $query->whereIn($field, $value);
            }
            // Otherwise, use a simple WHERE query
            else {
                $query->where($field, $value);
            }
        }

        // Return the query with the filters applied
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
    protected function applySorting(Builder $query, string|null $sortBy, string $sortDirection): Builder {
        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query;
    }
}
