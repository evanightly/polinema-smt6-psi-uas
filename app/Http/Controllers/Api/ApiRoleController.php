<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class ApiRoleController extends ApiController {
    private $roleService;
    private $roleRepository;

    public function __construct(RoleService $roleService, RoleRepository $roleRepository) {
        $this->roleService = $roleService;
        $this->roleRepository = $roleRepository;
    }

    public function index() {
        $options = request()->query('options', []);
        $searchFields = ['name'];
        $relations = ['users'];
        $roles = $this->roleRepository->get($options, $searchFields, $relations);
        return $this->apiPaginateResponse($roles, RoleResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request) {
        $role = $this->roleRepository->create($request->validated());
        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) {
        return new RoleResource($role->load(['supplier', 'transactions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role) {
        $role = $this->roleRepository->update($role, $request->validated());
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        $this->roleRepository->delete($role);
        return response()->noContent();
    }
}
