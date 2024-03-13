<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use App\Services\RoleService;
use Illuminate\Http\Request;
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
        $role = $this->roleService->createRole($request->validated(), $request->file('image'));
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
        $role = $this->roleService->updateRole($role, $request->validated(), $request->file('image'));
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        $this->roleService->deleteRole($role);
        return response()->noContent();
    }
}
