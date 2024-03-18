<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::inertia('/', 'Index');
    Route::inertia('pos', 'Pos')->middleware('role:SuperAdmin|Staff');
    Route::get('/products/restock', [ProductController::class, 'showRestockInfo'])->name('product.restock-info')->middleware('role:Staff');

    Route::resource('roles', RoleController::class)->middleware('role:SuperAdmin|Manager');
    Route::resource('users', UserController::class)->middleware('role:SuperAdmin|Manager');
    Route::resource('suppliers', SupplierController::class)->middleware('role:SuperAdmin|Staff|Manager');
    Route::resource('products', ProductController::class)->middleware('role:Staff');
    Route::resource('transactions', TransactionController::class)->middleware('role:Staff');


    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    })->name('logout');
});

Route::get('/hello', function () {
    return ('WOY');
});
