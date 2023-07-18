<?php

use App\Http\Controllers\API\UserAuthenticationController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Register, login, OAuth
Route::group(['prefix' => 'auth', 'controller' => UserAuthenticationController::class], function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
    Route::post('forgot-password', 'forgotPassword')->name('password.email');
    Route::get('reset-password/{token}', 'resetForm')->middleware('guest')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('password.update');

    // OAuth with Socialite
    Route::get('/login/{provider}', 'redirectToProvider');
    Route::get('/login/{provider}/callback', 'handleProviderCallback');

    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::post('send-otp', 'sendOTP');

});


Route::group(['middleware' => ['auth:sanctum']],  function() {
    Route::post('becomeTeacher', [UserController::class, 'becomeTeacher']);
});

