<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.signup');
});

Route::post('/submit-signup', [AuthController::class, 'signup_authenticate'])->name('signup.post');

Route::post('/signin-success', [AuthController::class, 'login_authenticate'])->name('signin.post');