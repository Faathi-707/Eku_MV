<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::view('/predict', 'Predict');

Route::view('/notification', 'Notification');

Route::view('/disruptions', 'Disruptions');

// Report Form Page
Route::get('/report', function () {
    return view('report');
});

Route::view('/profile', 'Profile');
