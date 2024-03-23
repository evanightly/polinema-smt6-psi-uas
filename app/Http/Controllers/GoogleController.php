<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller {
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        $googleUser = Socialite::driver('google')->user();

        // Download the user's avatar image from Google
        $response = Http::get($googleUser->getAvatar());

        if ($response->successful()) {
            // Save the image to a temporary file
            $tmpFile = tempnam(sys_get_temp_dir(), 'avatar');
            file_put_contents($tmpFile, $response->body());

            // Move the temporary file to the desired location
            $avatarPath = Storage::disk('public')->put('images/users', new File($tmpFile));

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'image_path' => $avatarPath,
                    'is_google_user' => true,
                    'password' => Hash::make(Str::random(16)),
                ]
            );

            auth()->login($user, true);

            $api_token = $user->createToken('api_token')->plainTextToken;

            return inertia('Auth/Login', ['api_token' => $api_token]);
        } else {
            // Handle the error
            // For now, let's just dump the response status
            dd($response->status());
        }
    }
}