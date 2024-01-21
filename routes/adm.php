<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AttributeController;
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
    Route::get('/login', [Admin\AuthController::class, 'loginPage'])->name('auth');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('auth');
    Route::get('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [Admin\IndexController::class, 'index'])->name('index');

        Route::get('/autodoc', [Admin\AutoDocController::class, 'autodoc'])->name('autodoc');
        Route::get('/specification', [Admin\AutoDocController::class, 'specification'])->name('specification');

        Route::get('/managers', [Admin\ManagerController::class, 'list'])->name('managers.list');
        Route::get('/managers/add', [Admin\ManagerController::class, 'add'])->name('managers.add');
        Route::get('/managers/edit', [Admin\ManagerController::class, 'edit'])->name('managers.edit');
        Route::post('/managers/store', [Admin\ManagerController::class, 'store'])->name('managers.store');
        Route::post('/managers/update', [Admin\ManagerController::class, 'update'])->name('managers.update');

        Route::get('/categories', [Admin\CategoriesController::class, 'list'])->name('categories.list');
        Route::get('/categories/add', [Admin\CategoriesController::class, 'add'])->name('categories.add');
        Route::post('/categories/store', [Admin\CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [Admin\CategoriesController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/{category}/update', [Admin\CategoriesController::class, 'update'])->name('categories.update');
        Route::post('/categories/{category}/delete', [Admin\CategoriesController::class, 'delete'])->name('categories.delete');

        Route::resource('admin/attributes', AttributeController::class);
    });
});