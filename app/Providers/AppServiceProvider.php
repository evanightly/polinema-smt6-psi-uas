<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;

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

        Fortify::loginView(function () {
            return Inertia::render('Auth/Login');
        });
        Fortify::registerView(function () {
            return Inertia::render('Auth/Register');
        });
    }
}
