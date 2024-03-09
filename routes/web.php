<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::inertia('/products', 'Product/Index');

Route::inertia('/products/create', 'Product/Create');

Route::get('/hello', function () {
    return ('WOY');
});
