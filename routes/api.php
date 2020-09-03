<?php

use App\Http\Controllers\Api\Account\AvatarController;
use App\Http\Controllers\Api\Account\PasswordController;
use App\Http\Controllers\Api\Account\ProfileController;
use App\Http\Controllers\Api\Building\BuildingsController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\Data\AssetCategoriesController;
use App\Http\Controllers\Api\Data\ProvincesController;
use App\Http\Controllers\Api\Space\SpaceController;
use App\Http\Controllers\Api\StaticPagesController;
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
Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        // Auth routes for guest...
        Route::middleware('guest')->group(function () {
            Route::post('login', [LoginController::class, 'login'])->name('login');
            Route::post('register', [RegisterController::class, 'register'])->name('register');
            Route::post('verify/resend', [VerificationController::class, 'resend'])->name('verify.resend');

            // Forgot password routes...
            Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        });

        // Auth routes for auth users
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        });
    });


/**
 * Account routes...
 */
Route::prefix('account')
    ->name('account.')
    ->middleware('auth:sanctum')
    ->group(function () {
        // Account profile routes...
        Route::get('profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // Account update avatar routes...
        Route::post('avatar', [AvatarController::class, 'update'])->name('avatar.update');

        // Account update password routes...
        Route::put('password', [PasswordController::class, 'update'])->name('password');
    });

/**
 * Assets routes ...
 */
Route::post('buildings', [BuildingsController::class, 'index'])->name('buildings');
Route::get('buildings/{id}', [BuildingsController::class, 'show'])->name('buildings.show');


/**
 * Term Of Condition & Privacy And Policy
 */
Route::get('static-pages/{slug}', [StaticPagesController::class , 'show'])->name('static-pages');

/**
 * Building Spaces
 */
Route::prefix('spaces')
    ->name('space')
    ->group(function(){
        Route::get('/' , [SpaceController::class , 'index'])->name('all');
        Route::get('/{id}' , [SpaceController::class , 'show'])->name('show');
    });

/**
 * Data routes...
 */
Route::prefix('data')
    ->name('data.')
    ->group(function () {
        Route::get('asset-categories', [AssetCategoriesController::class, 'index'])->name('asset-categories');
        Route::get('provinces', [ProvincesController::class, 'index'])->name('provinces');
    });
