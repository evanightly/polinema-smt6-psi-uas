<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class ApiUserController extends ApiController {

    private $userService;
    private $userRepository;

    public function __construct(UserService $userService, UserRepository $userRepository) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $options = request()->query('options', []);
        $searchFields = ['name'];
        $users = $this->userRepository->get($options, $searchFields);
        return $this->apiPaginateResponse($users, UserResource::class);
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
    public function store(StoreUserRequest $request) {
        $user = $this->userService->createUser($request->validated(), $request->file('image'));
        return $this->apiPaginateResponse($user, UserResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user) {
        $user = $this->userService->updateUser($user, $request->validated(), $request->file('image'));
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) {
        $this->userService->deleteUser($user);
        return response()->noContent();
    }
}
