<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(env('ADM_URL'))->name('admin.')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [Admin\IndexController::class, 'index'])->name('indexPage');

        Route::get('/autodoc', [Admin\AutoDocController::class, 'autodoc'])->name('autodoc');
        Route::get('/specification', [Admin\AutoDocController::class, 'specification'])->name('specification');

        Route::get('/managers', [Admin\ManagerController::class, 'list'])->name('managers.list');
    });
});