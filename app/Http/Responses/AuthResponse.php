<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class AuthResponse implements LoginResponseContract, RegisterResponseContract {
    public function toResponse($request) {
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : inertia('Index');
    }
}
