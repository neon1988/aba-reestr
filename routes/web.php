<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\WorksheetController;
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

    Route::resource('images', ImageController::class)->only(['store']);
    Route::resource('files', FileController::class)->only(['store']);

    Route::get('specialists/{specialist}/location_and_work', [SpecialistController::class, 'showLocationAndWork'])->name('specialists.location_and_work');
    Route::patch('specialists/{specialist}/location_and_work', [SpecialistController::class, 'updateLocationAndWork'])->name('specialists.location_and_work.update');

    Route::get('/specialists/{specialist}/education-and-documents', [SpecialistController::class, 'educationAndDocuments'])->name('specialists.education_and_documents');
    Route::get('/specialists/{specialist}/billing-and-payment-documents', [SpecialistController::class, 'billingAndPaymentDocuments'])->name('specialists.billing_and_payment_documents');
    Route::get('/specialists/{specialist}/delete-profile', [SpecialistController::class, 'deleteProfile'])->name('specialists.delete_profile');

    Route::get('/profile/password_change', [ProfileController::class, 'passwordChange'])->name('profile.password_change');
});

Route::resource('centers', CenterController::class)->only(['index', 'show']);
Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);
Route::resource('webinars', WebinarController::class)->only(['index', 'show']);
Route::resource('worksheets', WorksheetController::class)->only(['index', 'show']);
Route::resource('conferences', ConferenceController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/notification-preview', [PreviewController::class, 'notification'])->name('notification-preview');
Route::get('/privacy-policy', [OtherController::class, 'privacyPolicy'])->name('privacy-policy');

Route::get('/contacts', [OtherController::class, 'contacts'])->name('contacts');

require __DIR__.'/auth.php';
