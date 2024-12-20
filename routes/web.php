<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Models\User;
use Illuminate\Http\Request;

Route::middleware(['check:user,admin'])->group(function () {
    Route::get('/', function () {
        return view('layouts.base');
    })->name('index');
    Route::get('/teams', [TeamController::class, 'show'])->name('teams');
});

Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/submit-signup', [AuthController::class, 'signup_authenticate'])->name('signup.post');
Route::post('/signin-success', [AuthController::class, 'login_authenticate'])->name('signin.post');
Route::get('/loginGoogle', [AuthController::class, 'redirectToGoogle'])->name('user.auth');
Route::get('/auth/callback', [AuthController::class, 'loginGoogle'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::get('/api/users', [TeamController::class, 'searchLeader']);
    Route::get('/api/teams', [TeamController::class, 'searchTeams']);
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams', [TeamController::class, 'show'])->name('teams');
    Route::get('/teams/{team}/resource', [TeamController::class, 'showResource'])->name('teams.resource');
    Route::get('/teams/{team}/member', [TeamController::class, 'showMember'])->name('teams.member');
    Route::get('/teams/{team}/audit', [TeamController::class, 'showAudit'])->name('teams.audit');
    Route::post('/promote', [TeamController::class, 'promote'])->name('promote');
    Route::post('/demote', [TeamController::class, 'demote'])->name('demote');
    Route::post('/kick', [TeamController::class, 'kick'])->name('kick');
    Route::post('/addMember', [TeamController::class, 'addMember'])->name('addMember');

    Route::post('/accessResource/{teamResource}', [TeamController::class, 'accessTeamResource'])->name('accessResource');

    // For all routes to /resource, we need to make sure it's an admin.
    Route::middleware(AdminMiddleware::class)->prefix('/resource')->name('resource.')->group(function () {
        Route::get('/', [ResourceController::class, 'list'])->name('list');
        Route::get('/create/{type}', [ResourceController::class, 'create'])->name('create');
        Route::get('/{resource}', [ResourceController::class, 'show'])->name('show');
        Route::post('/{type}', [ResourceController::class, 'store'])->name('store');
        Route::delete('/{resource}', [ResourceController::class, 'delete'])->name('delete');
    });
    // Route::get('/resources/create', function () { return view('create-resource'); });
});

Route::middleware(['check:admin'])->group(function () {});
