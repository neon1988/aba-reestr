<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OtherController::class, 'home'])->name('home');

Route::get('/specialists', [SpecialistController::class, 'index'])->name('specialists.index');
Route::get('/centers', [CenterController::class, 'index'])->name('centers.index');
//Route::get('/board', [OtherController::class, 'centers'])->name('board.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/join', [JoinController::class, 'join'])->name('join');
    Route::get('/join/specialist', [JoinController::class, 'specialist'])->name('join.specialist');
    Route::get('/join/center', [JoinController::class, 'center'])->name('join.center');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contacts', [OtherController::class, 'contacts'])->name('contacts');

require __DIR__.'/auth.php';
