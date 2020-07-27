<?php

use App\Http\Controllers\Api\Auth\VerificationController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        // Auth routes for guest...
        Route::middleware('guest')->group(function () {
            Route::get('verify', [VerificationController::class, 'verify'])->name('verify');
            Route::get('verify/email-verified', [VerificationController::class, 'showEmailVerifiedPage'])->name('verify.email-verified');
        });
    });
