<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::get('signup', [SignupController::class, 'index'])->name('signup');
Route::post('signup', [SignupController::class, 'store'])->name('signup.store');
