<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['Role:1'])->get('/demo', function () {
    return User::all();
});

Route::prefix('/v1')->group(function ($route) {
    $route->prefix('/auth')->group(function ($route) {
        $route->post('/signin', [AuthController::class, 'login'])->name('login');
        $route->post('/signup', [AuthController::class, 'register'])->name('register');
        $route->post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
        $route->post('/reset', [AuthController::class, 'reset'])->name('reset');
    })->name('auth.');
    $route->middleware(['Authorized'])->group(function ($route) {
        $route->resource('/users', UserController::class)->except(['create', 'edit']);

        $route->prefix('/auth')->group(function ($route) {
            $route->post('/avatar', [UserController::class, 'avatar'])->name('avatar');
        })->name('auth.');
    });
})->name('v1.');
