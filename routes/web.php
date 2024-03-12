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

Route::inertia('/', 'Index');

Route::inertia('/login', 'Login');

Route::inertia('/register', 'Register');

Route::resource('roles', RoleController::class);

Route::resource('users', UserController::class);

Route::resource('suppliers', SupplierController::class);

Route::resource('products', ProductController::class);

Route::resource('transactions', TransactionController::class);



Route::get('/hello', function () {
    return ('WOY');
});
