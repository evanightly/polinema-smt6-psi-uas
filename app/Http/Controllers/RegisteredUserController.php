<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller {
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actions\Fortify\CreateNewUser  $creator
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, CreateNewUser $creator) {
        event(new Registered($user = $creator->create($request->all())));

        $api_token = $user->createToken('api_token')->plainTextToken;

        Auth::login($user);

        return $api_token;
    }
}
