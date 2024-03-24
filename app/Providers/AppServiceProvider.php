<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Http\Responses\AuthResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        JsonResource::withoutWrapping();
        // Paginator::useTailwind();

        Fortify::loginView(fn () => inertia('Auth/Login'));
        Fortify::registerView(fn () => inertia('Auth/Register'));
        Fortify::requestPasswordResetLinkView(fn () => inertia('Auth/ForgotPassword'));
        Fortify::resetPasswordView(fn () => inertia('Auth/ResetPassword', ['token' => request()->route('token'), 'email' => request()->email]));
        Fortify::verifyEmailView(fn () => inertia('Auth/VerifyEmail'));

        $this->app->bind(ResetsUserPasswords::class, ResetUserPassword::class); // Target [Laravel\Fortify\Contracts\ResetsUserPasswords] is not instantiable.
        $this->app->singleton(LoginResponseContract::class, AuthResponse::class);
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
    }
}
