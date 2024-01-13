<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ListingsController;
use App\Http\Controllers\Api\UserController;
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
Route::domain(env('API_URL'))->middleware('api')->name('api.')->group(function () {
    Route::prefix('v1')->middleware('api')->group(function () {
        Route::post('/login', [UserController::class, 'login'])->name('login');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::post('/register', [UserController::class, 'register'])->name('register');

        Route::get('/categories', [CategoriesController::class, 'index']);
        Route::get('/listings', [ListingsController::class, 'index'])->name('listings.index');
        Route::get('/listings/{listing}', [ListingsController::class, 'show'])->name('listings.show');

        /** Авторизованная зона */
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/listings', [ListingsController::class, 'store']);
            Route::post('/listings/{listing}/update', [ListingsController::class, 'update']);
            Route::post('/listings/{listing}/delete', [ListingsController::class, 'destroy']);

            Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
            Route::get('/profile/{user}', [UserController::class, 'getProfile'])->name('user.getProfile');
            Route::post('/changeProfile', [UserController::class, 'changeProfile'])->name('user.changeProfile');
            Route::post('/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword');
        });
    });
});