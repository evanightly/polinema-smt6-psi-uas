<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;
use App\Http\Responses\AuthResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

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

        Fortify::loginView(fn () => Inertia::render('Auth/Login'));
        Fortify::registerView(fn () => Inertia::render('Auth/Register'));

        $this->app->singleton(LoginResponseContract::class, AuthResponse::class);
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
    }
}
