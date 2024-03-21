<?php

use App\Http\Controllers\Api\ApiNotificationController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiRoleController;
use App\Http\Controllers\Api\ApiSupplierController;
use App\Http\Controllers\Api\ApiTransactionController;
use App\Http\Controllers\Api\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->name('api.')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user()->load('unreadNotifications'));
    Route::get('/notifications/{id}', [ApiNotificationController::class, 'index'])->middleware('role:Staff');
    Route::post('/notifications/mark-as-finish', [ApiNotificationController::class, 'markAsFinish'])->middleware('role:Staff');

    Route::apiResource('roles', ApiRoleController::class)->middleware('role:SuperAdmin|Manager');
    // Route::apiResource('users', ApiUserController::class)->middleware('role:SuperAdmin|Manager');
    Route::apiResource('suppliers', ApiSupplierController::class)->middleware('role:SuperAdmin|Staff|Manager');
    Route::apiResource('products', ApiProductController::class)->middleware('role:Staff');
    // Route::apiResource('transactions', ApiTransactionController::class)->middleware('role:Staff');
});
Route::apiResource('users', ApiUserController::class);

Route::apiResource('transactions', ApiTransactionController::class);
