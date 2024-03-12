<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class RoleRepository extends Repository {

    public function get(array $options = [], array $searchFields = [], array $relations = []): Builder {
        $query = Role::query();

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

    public function create(array $data): Role {
        return Role::create($data);
    }

    public function update(Role $role, array $data): Role {
        $role->update($data);
        return $role->refresh();
    }

    public function delete(Role $role): void {
        $role->delete();
    }
}
