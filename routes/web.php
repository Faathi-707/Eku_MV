<?php

use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\DisruptionReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');

    Route::view('/predict', 'Predict')->name('predict');

    Route::view('/notification', 'notification')->name('notification');

    Route::view('/profile', 'profile')->name('profile');

    Route::get('/disruptions', [DisruptionReportController::class, 'index'])->name('disruptions');
    Route::get('/report', [DisruptionReportController::class, 'create'])->name('report');
    Route::post('/report', [DisruptionReportController::class, 'store'])->name('report.store');
    Route::get('/report/{disruptionReport}/edit', [DisruptionReportController::class, 'edit'])->name('report.edit');
    Route::put('/report/{disruptionReport}', [DisruptionReportController::class, 'update'])->name('report.update');
    Route::delete('/disruptions/{disruptionReport}', [DisruptionReportController::class, 'destroy'])->name('disruptions.destroy');

    Route::post('/api/predict', [PredictionController::class, 'predict'])->name('api.predict');
});

require __DIR__.'/auth.php';
