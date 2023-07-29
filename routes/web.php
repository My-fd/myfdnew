<?php

use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\ListingsController;
use App\Http\Controllers\Web\MessagesController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;

Route::domain(env('APP_URL'))->group(function () {
    Route::name('web.')->group(function () {
        // Зона доступная неавторизованным пользователям
        Route::get('/', [IndexController::class, 'index'])->name('home');
        Route::get('/search', [SearchController::class, 'search'])->name('search');
        Route::get('/login', [UserController::class, 'login'])->name('login');
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
        Route::post('/auth', [UserController::class, 'auth'])->name('auth');
        Route::get('/register', [UserController::class, 'register'])->name('register');
        Route::post('/register', [UserController::class, 'signup'])->name('signup');

        // Зона доступная авторизованным пользователям
        Route::middleware('auth:web')->group(function () {
            // Аккаунт пользователя
            Route::name('user.')->prefix('user')->group(function () {
                Route::get('/account', [UserController::class, 'account'])->name('account');
            });

            // Объявления
            Route::name('listings.')->prefix('listings')->group(function () {
                Route::get('/create-ad', [ListingsController::class, 'createAd'])->name('createAd');
            });

            // Чат
            Route::name('messages.')->prefix('messages')->group(function () {
                Route::get('/', [MessagesController::class, 'index'])->name('index');
            });
        });
    });
});
