<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Authentication routes...
 */
Route::prefix('auth')->name('auth.')->group(function () {

    // Auth routes for guest...
    Route::middleware('guest')->group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('register', [RegisterController::class, 'register'])->name('register');
        Route::get('verify', [VerificationController::class, 'verify'])->name('verify');

        // Forgot password routes...
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    });

    // Auth routes for auth users
    Route::middleware('auth:sanctum')->group(function () {
        //
    });
});


/**
 * Account routes...
 */
Route::get('account', [AccountController::class, 'show'])->name('account');
Route::put('account', [AccountController::class, 'update'])->name('account.update');
