<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.base');
})->name('index');

Route::get('/teams', function () {
    return view('teams');
})->name('teams');
