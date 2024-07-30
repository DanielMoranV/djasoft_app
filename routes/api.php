<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'store'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::group(
    [
        'middleware' => ['auth:api', 'role:dev'],
        'prefix' => 'roles'
    ],
    function () {
        Route::get('/', [RoleController::class, 'getRoles'])->name('getRoles');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/user/{name}', [RoleController::class, 'update'])->name('update');
        Route::put('/user', [RoleController::class, 'assignRole'])->name('assignRole');
        Route::delete('/user', [RoleController::class, 'removeRole'])->name('removeRole');
    }
);
Route::group(
    [
        'middleware' => ['auth:api', 'role:dev'],
        'prefix' => 'users'
    ],
    function () {
        Route::post('/storeUsers', [UserController::class, 'storeUsers'])->name('storeUsers');
        Route::patch('/{id}/restore', [UserController::class, 'restore'])->name('restore');
    }
);
Route::apiResource('/users', UserController::class);
Route::apiResource('/companies', CompanyController::class);