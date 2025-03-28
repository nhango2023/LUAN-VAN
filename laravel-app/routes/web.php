<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SignupController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::get('signup', [SignupController::class, 'index'])->name('signup');
Route::post('signup', [SignupController::class, 'store'])->name('signup.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/show', [UserController::class, 'index'])->name('show');
        Route::get('/personal/edit/{id}', [UserController::class, "showFormPersonal"])->name('personal.edit');
        Route::put('/personal/edit/{id}', [UserController::class, "updatePersonalInfor"])->name('personal.edit');
        Route::get('/create', [UserController::class, "showFormCreate"])->name('create');
        Route::post('/create', [UserController::class, "create"])->name('create');
        Route::post('/create', [UserController::class, "create"])->name('create');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
});

Route::get('logout', [LogoutController::class, 'index'])->name('logout');
