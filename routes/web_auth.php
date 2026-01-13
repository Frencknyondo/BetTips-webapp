<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TipController;

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/password/email', [AuthController::class, 'sendPasswordResetEmail'])->name('password.email');

// Account
Route::get('/account', [AccountController::class, 'index'])->middleware('auth')->name('account');
Route::post('/account/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->middleware('auth')->name('account.update-profile-picture');

// Tipster Application
Route::get('/tipster/apply', [AccountController::class, 'showApplicationForm'])->middleware('auth')->name('tipster.apply');
Route::post('/tipster/apply', [AccountController::class, 'submitApplication'])->middleware('auth')->name('tipster.submit');

// Tips
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/{tip}', [TipController::class, 'show'])->name('tips.show');
Route::post('/tips', [TipController::class, 'store'])->middleware('auth')->name('tips.store');
Route::post('/tips/{tip}/unlock', [TipController::class, 'unlock'])->middleware('auth')->name('tips.unlock');
