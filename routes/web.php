<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::view('/predict', 'Predict');

Route::view('/notification', 'Notification');
