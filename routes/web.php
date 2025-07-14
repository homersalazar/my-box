<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::prefix('home')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files.index');
});


Route::prefix('share')->group(function () {
    Route::get('/', [ShareController::class, 'index'])->name('shares.index');
});

Route::prefix('account')->group(function () {
    Route::get('/signup', [UserController::class, 'signup'])->name('account.signup');
    Route::post('/login', [UserController::class, 'login'])->name('account.login');
    Route::post('/register', [UserController::class, 'register'])->name('account.register');
    Route::get('/logout', [UserController::class, 'logout'])->name('account.logout');
});
