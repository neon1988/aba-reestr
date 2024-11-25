<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OtherController::class, 'home'])->name('home');

Route::get('/specialists/on_check', [SpecialistController::class, 'on_check'])->name('specialists.on_check');

//Route::get('/board', [OtherController::class, 'centers'])->name('board.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/join', [JoinController::class, 'join'])->name('join');
    Route::get('/join/specialist', [JoinController::class, 'specialist'])->name('join.specialist');
    Route::get('/join/center', [JoinController::class, 'center'])->name('join.center');

    Route::resource('centers', CenterController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
    Route::resource('specialists', SpecialistController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
});

Route::resource('centers', CenterController::class)->only(['index', 'show']);
Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/notification-preview', [PreviewController::class, 'notification']);


Route::get('/contacts', [OtherController::class, 'contacts'])->name('contacts');

require __DIR__.'/auth.php';
