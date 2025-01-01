<?php

use App\Http\Controllers\Api\v1\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['Role:1'])->get('/demo', function () {
    return User::all();
});

Route::prefix('/v1')->group(function ($route) {
    $route->resource('/users', UserController::class)->except(['create', 'edit']);
})->name('first_version.');
