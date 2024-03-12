<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use App\Services\RoleService;

class ApiRoleController extends ApiController {

    private $roleService;
    private $roleRepository;

    public function __construct(RoleService $roleService, RoleRepository $roleRepository) {
        $this->roleService = $roleService;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $options = request()->query('options', []);
        $searchFields = ['name'];
        $roles = $this->roleRepository->get($options, $searchFields);
        return $this->apiPaginateResponse($roles, RoleResource::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        //
    }
}
