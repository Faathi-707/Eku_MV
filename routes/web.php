<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Logged-out visitors
Route::middleware('guest')->group(function () {
    Route::view('/login', 'Both.Login')->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::view('/create', 'Both.create')->name('create');
    Route::view('/createaccount', 'Citizen.createaccount')->name('createaccount');
    Route::post('/createaccount', [RegisterController::class, 'citizen'])->name('createaccount.store');
    Route::view('/official/createaccount', 'Official.Createaccount')->name('official.createaccount');
    Route::post('/official/createaccount', [RegisterController::class, 'official'])->name('official.createaccount.store');

    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Logged in
Route::middleware('auth')->group(function () {
    Route::view('/', 'Both.dashboard')->name('dashboard');

    Route::middleware('role:citizen')->group(function () {
        Route::view('/predict', 'Citizen.Predict')->name('predict');
        Route::view('/notifications', 'Citizen.notification')->name('notifications');
        Route::view('/profile', 'Citizen.profile')->name('profile');
    });

    Route::middleware('role:official,admin')->prefix('official')->name('official.')->group(function () {
        Route::view('/disruptions', 'Official.Disruptions')->name('disruptions.index');
        Route::view('/reports', 'Official.report')->name('reports');
        Route::view('/profile', 'Official.Oprofile')->name('profile');
    });
});