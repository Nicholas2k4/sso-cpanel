<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::middleware(['check:user,admin'])->group(function () {
    Route::get('/', function () {
        return view('layouts.base');
    })->name('index');
    Route::get('/teams', [TeamController::class, 'show'])->name('teams');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/submit-signup', [AuthController::class, 'signup_authenticate'])->name('signup.post');

Route::post('/signin-success', [AuthController::class, 'login_authenticate'])->name('signin.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams', [TeamController::class, 'show'])->name('teams');
});

Route::get('/loginGoogle', [AuthController::class, 'redirectToGoogle'])->name('user.auth');

Route::get('/auth/callback', [AuthController::class, 'loginGoogle'])->name('login.process');
