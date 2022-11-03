<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ForgotPasswordSuccessController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PasswordResetExpiredController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\ChangePasswordController;

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

Route::get('/', function () {
    return redirect(route('login.index'));
});
Route::resource('login', LoginController::class);
Route::resource('forgot_password', ForgotPasswordController::class);
Route::resource('forgot_password_complete', ForgotPasswordSuccessController::class);
Route::resource('password_reset', PasswordResetController::class);
Route::resource('password_reset_expired', PasswordResetExpiredController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group([
    'middleware' => ['adminAuth'],
], function () {
    Route::resource('dashboard', DashboardController::class, ['as' => 'admin']);
});
Route::group([
    'middleware' => ['admin'],
], function () {
    Route::resource('user', UserController::class, ['as' => 'admin']);
    Route::post('check-email', [UserController::class, 'checkEmail'])->name('admin.user.checkEmail');
    Route::put('match-guess/{id}', [MatchController::class, 'updateGuess'])->name('match.update-guess');
    Route::resource('match', MatchController::class);
});

Route::group([
    'middleware' => ['user'],
], function () {
    Route::resource('predict', PredictController::class);
    Route::get('result', [PredictController::class, 'result'])->name('result');
    Route::resource('change-password', ChangePasswordController::class);
});
