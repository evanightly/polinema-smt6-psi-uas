<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Http\Request;

class CustomAuthenticatedSessionController extends FortifyAuthenticatedSessionController {
    public function destroy(Request $request): LogoutResponse {
        $request->user()->tokens()->delete();
        auth()->logout();

        return app(LogoutResponse::class);
    }
}
