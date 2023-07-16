<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\LoginController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\StudentController;
use App\Http\Controllers\Panel\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']],  function() {
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index']);
Route::get('/admin-home', [DashboardController::class, 'index']);
Route::get('/student', [StudentController::class, 'index']);
Route::get('/teacher', [TeacherController::class, 'index']);
