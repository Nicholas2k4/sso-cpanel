<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['check:user,admin'])->group(function () {
    Route::get('/', function () { return view('layouts.base'); })->name('index');
    Route::get('/teams', function () { return view('teams'); })->name('teams');
});


Route::get('/login', function () { return view('auth.login'); })->name('login');

Route::get('/signup', function () { return view('auth.signup'); })->name('signup');

Route::post('/submit-signup', [AuthController::class, 'signup_authenticate'])->name('signup.post');

Route::post('/signin-success', [AuthController::class, 'login_authenticate'])->name('signin.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/loginGoogle', [AuthController::class, 'redirectToGoogle'])->name('user.auth');

Route::get('/processLogin', [AuthController::class, 'loginGoogle'])->name('login.process');