<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::get('signup', [SignupController::class, 'index'])->name('signup');
Route::post('signup', [SignupController::class, 'store'])->name('signup.store');

Route::prefix('admin')->name('admin.')->middleware('canAccessAdminPage')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/show', [UserController::class, 'index'])->name('show');

        Route::get('/personal/show/{id}', [UserController::class, "showFormPersonal"])->name('personal.show');
        Route::put('/personal/edit/{id}', [UserController::class, "updatePersonalInfor"])->name('personal.edit');

        Route::get('/create', [UserController::class, "showFormCreate"])->name('create');
        Route::post('/create', [UserController::class, "create"])->name('create');

        Route::get('/advanced/show/{id}', [UserController::class, "showFormAdvanced"])->name('advanced.show');
        Route::put('/advanced/password/edit/{id}', [UserController::class, "updatePassWord"])->name('advanced.password.edit');
        Route::put('/advanced/credit/edit/{id}', [UserController::class, "updateCredit"])->name('advanced.credit.edit');

        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
});

Route::get('logout', [LogoutController::class, 'index'])->name('logout');

Route::prefix('question')->name('question.')->group(function () {
    Route::post('/create', [QuestionController::class, 'create'])->name('create');
    Route::get('/show', [QuestionController::class, 'show'])->name('show');
});

Route::get('taomatkhau', function () {
    dd(Hash::make('1'));
});

// Route::get('test-api', function () {
//     try {
//         $response = Http::timeout(5)->get('http://localhost:8000/test-call-api');

//         if ($response->successful()) {

//             $text = $response->json();

//             return view('welcome', compact('text'));
//         } else {
//             return ['error' => $response->status()];
//         }
//     } catch (\Exception $e) {
//         return ['error' => $e->getMessage()];
//     }
// });
