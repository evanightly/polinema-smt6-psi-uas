<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository {
    public function get(array $options = [], array $searchFields = [], array $relations = []): Builder {
        $query = Role::query();
        if (!empty($relations)) {
            $query = $query->with($relations);
        }
        if (isset($options['filters'])) {
            $query = $this->applyFilters($query, $options['filters'], $searchFields);
        }
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
