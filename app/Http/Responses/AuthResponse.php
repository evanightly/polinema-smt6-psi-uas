<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class AuthResponse implements LoginResponseContract, RegisterResponseContract {
    public function toResponse($request) {
        $apiToken = $request->user()->createToken('api_token')->plainTextToken;
        return $request->wantsJson()
            ? new JsonResponse(['api_token' => $apiToken], 201)
            : inertia('Index');
    }
}
