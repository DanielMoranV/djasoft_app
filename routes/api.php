<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'store'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('auth.refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('auth.me');
});

// Role Management Routes
Route::group([
    'middleware' => ['auth:api', 'role:dev|admin'],
    'prefix' => 'roles'
], function () {
    Route::get('/', [RoleController::class, 'getRoles'])->name('roles.index');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/user', [RoleController::class, 'assignRole'])->name('roles.assign');
    Route::delete('/user', [RoleController::class, 'removeRole'])->name('roles.remove');
});

// User Management Routes
Route::group([
    'middleware' => ['auth:api', 'role:dev|admin'],
    'prefix' => 'users'
], function () {
    Route::post('/store', [UserController::class, 'storeUsers'])->name('users.storeMultiple');
    Route::patch('/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/{id}/photoprofile', [UserController::class, 'photoProfile'])->name('users.photoProfile');
    Route::get('/', [UserController::class, 'index'])->name('users.index');
});
Route::apiResource('users', UserController::class)->middleware('role:dev|admin');

// Company Management Routes
Route::group([
    'middleware' => ['auth:api', 'role:dev|admin'],
    'prefix' => 'companies'
], function () {
    Route::post('/{id}/logo', [CompanyController::class, 'logo'])->name('companies.logo');
});
Route::apiResource('companies', CompanyController::class)->middleware('role:dev|admin');

// Product Management Routes
Route::group([
    'middleware' => ['auth:api', 'role:dev|admin'],
    'prefix' => 'products'
], function () {
    Route::post('/store', [ProductController::class, 'storeProducts'])->name('products.storeMultiple');
});
Route::apiResource('products', ProductController::class)->middleware('role:dev|admin');

// Category Management Routes
Route::group([
    'middleware' => ['auth:api', 'role:dev|admin'],
    'prefix' => 'categories'
], function () {
    Route::post('/store', [CategoryController::class, 'storeCategories'])->name('categories.storeMultiple');
});
Route::apiResource('categories', CategoryController::class)->middleware('role:dev|admin');

// Unit Management Routes
Route::group(
    [
        'middleware' => ['auth:api', 'role:dev|admin'],
        'prefix' => 'units'
    ],
    function () {
        Route::post('/store', [UnitController::class, 'storeUnits'])->name('units.storeMultiple');
    }
);
Route::apiResource('units', UnitController::class)->middleware('role:dev|admin');

// StockMovements Management Routes
Route::apiResource('stock-movements', StockMovementController::class)->middleware('role:dev|admin');
Route::group(
    [
        // 'middleware' => ['auth:api', 'role:dev|admin'],
        'prefix' => 'stock-movements'
    ],
    function () {

        Route::post('/store-entry', [StockMovementController::class, 'storeEntry'])->name('stock-movements.store-entry');
    }
);
