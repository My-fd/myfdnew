<?php

use App\Http\Controllers\Api\AddressController;
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
        /** Авторизованная зона */
        Route::middleware('auth:sanctum')->group(function () {
            /** Объявления */
            Route::get('/listings/my', [ListingsController::class, 'my'])->name('listings.my');
            Route::post('/listings', [ListingsController::class, 'store'])->name('listings.store');
            Route::post('/listings/{listing}/update', [ListingsController::class, 'update'])->name('listings.update');
            Route::post('/listings/{listing}/delete', [ListingsController::class, 'destroy'])->name('listings.destroy');

            /** Профиль */
            Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
            Route::get('/sendVerify', [UserController::class, 'sendVerify'])->name('user.sendVerify');
            Route::get('/profile/{user}', [UserController::class, 'getProfile'])->name('user.getProfile');
            Route::post('/changeProfile', [UserController::class, 'changeProfile'])->name('user.changeProfile');
            Route::post('/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword');

            /** Адреса */
            Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
            Route::get('/addresses/ac', [AddressController::class, 'ac'])->name('addresses.ac');
            Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
            Route::get('/addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
            Route::post('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
            Route::post('/addresses/{address}/delete', [AddressController::class, 'delete'])->name('addresses.delete');
        });

        /** Неавторизованная зона */
        Route::get('/categories', [CategoriesController::class, 'index']);
        Route::get('/listings', [ListingsController::class, 'index'])->name('listings.index');
        Route::get('/listings/{listing}', [ListingsController::class, 'show'])->name('listings.show');

        Route::post('/login', [UserController::class, 'login'])->name('login');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::post('/register', [UserController::class, 'register'])->name('register');
        Route::get('/verify/{token}', [UserController::class, 'verify'])->name('verify');
    });
});