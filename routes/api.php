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
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/register', [UserController::class, 'register']);

        Route::get('/categories', [CategoriesController::class, 'index']);

        Route::middleware('api')->group(function () {
            Route::get('/listings', [ListingsController::class, 'index'])->name('listings.index');
            Route::post('/listings', [ListingsController::class, 'store']);
            Route::get('/listings/{listing}', [ListingsController::class, 'show'])->name('listings.show');
            Route::post('/listings/{listing}/update', [ListingsController::class, 'update']);
            Route::post('/listings/{listing}/delete', [ListingsController::class, 'destroy']);
        });
    });
});