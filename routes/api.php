<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', [AuthController::class, 'user'])->name('user');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/photos', [UserController::class, 'updatePhoto'])->name('users.photos.update');

    Route::get('/specialists/on_check', [SpecialistController::class, 'on_check'])->name('specialists.on_check');

    Route::resource('centers', CenterController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
    Route::resource('specialists', SpecialistController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);

    Route::resource('centers', CenterController::class)->only(['index', 'show']);
    Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);

    Route::put('/specialists/{specialist}/approve', [SpecialistController::class, 'approve'])->name('specialists.approve');
    Route::put('/specialists/{specialist}/reject', [SpecialistController::class, 'reject'])->name('specialists.reject');

    Route::put('/centers/{center}/approve', [CenterController::class, 'approve'])->name('centers.approve');
    Route::put('/centers/{center}/reject', [CenterController::class, 'reject'])->name('centers.reject');
});
