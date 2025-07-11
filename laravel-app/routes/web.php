<?php

use App\Http\Controllers\AdditionQuestionController;
use App\Http\Controllers\Admin\ConfigWebController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\aiModelController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ExportFileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;

// Route::middleware('checkConfig')->group(function () {
//     Route::get('/', function () {
//         $configWeb = ConfigWeb::where('isUse', 1)->first();
//         return view('home', compact('configWeb'));
//     })->name('home');
// });

Route::middleware('checkConfig')->group(function () {
    Route::get('/', [HomeController::class, "show"])->name('home');
});

Route::prefix('/config')->name('config.')->group(function () {
    Route::get('/', function () {
        return view('config');
    });
    Route::post('/create', [ConfigController::class, "create"])->name('create');
});


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::post('auth/google/register', [GoogleAuthController::class, 'registerWithGoogle'])->name('register.with.google');

Route::prefix('/profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'showAccountInfor'])->name('account-infor');
    Route::put('/update/fullname', [ProfileController::class, "updateFullName"])->name('update.fullname');
    Route::put('/update/password', [ProfileController::class, "updatePassword"])->name('update.password');
    Route::get('/buy-credit', [ProfileController::class, 'showBuyCredit'])->name('buy-credit');
    Route::get('/payment/history', [ProfileController::class, 'paymentHistory'])->name('payment-history');
    Route::get('/payment', [ProfileController::class, 'showPaymentPage'])->name('show-payment-page');
    Route::get('/payment/confirm/{id_plan}/{questions}', [ProfileController::class, 'paymentConfirm'])->name('payment-confirm');
});


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::get('signup', [SignupController::class, 'index'])->name('signup');
Route::post('signup', [SignupController::class, 'create'])->name('signup.create');

Route::get('/export/word/{fileId}', [ExportFileController::class, 'exportToWord'])->name('export.word');

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
    Route::prefix('/ai-model')->name('ai-model.')->group(function () {
        Route::get('/show', [aiModelController::class, "show"])->name('show');
        Route::put('/edit/api-key', [aiModelController::class, "editApiKey"])->name('api-key.edit');
        Route::put('/api-key/sync', [aiModelController::class, "syncApiKey"])->name('api-key.async');
    });
    Route::prefix('/config-web')->name('config-web.')->group(function () {
        Route::get('/show', [ConfigWebController::class, "show"])->name('show');
        Route::get('/detail/{id}', [ConfigWebController::class, "showDetail"])->name('detail');
        Route::put('/update/website/config{id}', [ConfigWebController::class, "updateWebConfig"])->name('update.website.config');
        Route::put('/update/company/config{id}', [ConfigWebController::class, "updateCompanyConfig"])->name('update.company.config');
    });

    Route::prefix('/plan')->name('plan.')->group(function () {
        Route::get('/show', [PlanController::class, "show"])->name('show');
        Route::get('/create', [PlanController::class, "showFormCreate"])->name('show-form-create');
        Route::post('/create', [PlanController::class, "create"])->name('create');
        Route::get('/detail/{id}', [PlanController::class, "detail"])->name('detail');
        Route::put('/update/{id}', [PlanController::class, "update"])->name('update');
        Route::delete('delete/{id}', [PlanController::class, 'delete'])->name('delete');
    });
    Route::prefix('/payment')->name('payment.')->group(function () {
        Route::get('/show', [PaymentController::class, "show"])->name('show');
        Route::put('/update/{id_payment}/{action}', [PaymentController::class, "update"])->name('update');
    });
    Route::prefix('/addition-question')->name('addition-question.')->group(function () {
        Route::get('/show', [AdditionQuestionController::class, "show"])->name('show');
        Route::get('/create', [AdditionQuestionController::class, "showFormCreate"])->name('show-form-create');
        Route::post('/create', [AdditionQuestionController::class, "create"])->name('create');
        Route::get('/detail/{id}', [AdditionQuestionController::class, "detail"])->name('detail');
        Route::put('/update/{id}', [AdditionQuestionController::class, "update"])->name('update');
        Route::delete('delete/{id}', [AdditionQuestionController::class, 'delete'])->name('delete');
        Route::put('/update-active/{id}', [AdditionQuestionController::class, "updateActive"])->name('update-active');
    });
});

Route::get('logout', [LogoutController::class, 'index'])->name('logout');

Route::prefix('question')->name('question.')->group(function () {
    Route::post('/start', [QuestionController::class, 'start'])->name('start');
    Route::post('/new', [QuestionController::class, 'new'])->name('new');
    Route::get('/show/{id_file?}', [QuestionController::class, 'show'])->name('show');
});

Route::prefix('message')->name('message.')->group(function () {

    Route::get('/show', [MessageController::class, 'show'])->name('show');
    Route::put('/update/{id_message}', [MessageController::class, 'update'])->name('update');
});

Route::get('taomatkhau', function () {
    dd(Hash::make('1'));
});

Route::get('test-ui', function () {
    return view('testui');
});

Route::get('not-available-on-mobile', function () {
    return view('not-available-on-mobile');
})->name('not-available-on-mobile');
