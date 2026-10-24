<?php

use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DisruptionReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/login', 'Both.Login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::view('/create', 'Both.create')->name('create');

    Route::view('/createaccount', 'Citizen.createaccount')->name('createaccount');
    Route::post('/createaccount', [RegisterController::class, 'citizen'])->name('createaccount.store');

    Route::view('/official/createaccount', 'Official.Createaccount')->name('official.createaccount');
    Route::post('/official/createaccount', [RegisterController::class, 'official'])->name('official.createaccount.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/', 'Both.dashboard')->name('dashboard');

    Route::post('/api/predict', [PredictionController::class, 'predict'])->name('api.predict');

    Route::middleware('role:citizen')->group(function () {
        Route::view('/predict', 'Citizen.Predict')->name('predict');
        Route::view('/notifications', 'Citizen.notification')->name('notifications');
        Route::view('/profile', 'Citizen.profile')->name('profile');
    });

    Route::middleware('role:official,admin')->prefix('official')->group(function () {
        Route::get('/disruptions', [DisruptionReportController::class, 'index'])->name('disruptions');
        Route::get('/reports', [DisruptionReportController::class, 'create'])->name('report');
        Route::post('/reports', [DisruptionReportController::class, 'store'])->name('report.store');
        Route::get('/reports/{disruptionReport}/edit', [DisruptionReportController::class, 'edit'])->name('report.edit');
        Route::put('/reports/{disruptionReport}', [DisruptionReportController::class, 'update'])->name('report.update');
        Route::delete('/disruptions/{disruptionReport}', [DisruptionReportController::class, 'destroy'])->name('disruptions.destroy');
        Route::view('/profile', 'Official.Oprofile')->name('official.profile');
    });
});
