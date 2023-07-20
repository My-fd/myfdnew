<?php

use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('web.home');
Route::get('/user/account', [UserController::class, 'account'])->name('web.user.account');
Route::get('/register', [UserController::class, 'register'])->name('web.user.register');
Route::post('/register', [UserController::class, 'signup'])->name('web.user.signup');
Route::get('/login', [UserController::class, 'login'])->name('web.user.login');
Route::post('/login', [UserController::class, 'auth'])->name('web.user.auth');
Route::get('/search', [\App\Http\Controllers\Web\SearchController::class, 'search'])->name('web.search');
