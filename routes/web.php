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

//Route::get('/board', [OtherController::class, 'centers'])->name('board.index');

Route::get('/join', [JoinController::class, 'join'])->name('join');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/specialists/on_check', [SpecialistController::class, 'on_check'])->name('specialists.on_check');

    Route::get('/join/specialist', [JoinController::class, 'specialist'])->name('join.specialist');
    Route::get('/join/center', [JoinController::class, 'center'])->name('join.center');

    Route::resource('centers', CenterController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
    Route::resource('specialists', SpecialistController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);

    Route::resource('images', ImageController::class)->only(['store']);
    Route::resource('files', FileController::class)->only(['store']);

    Route::get('specialists/{specialist}/location-and-work', [SpecialistController::class, 'showLocationAndWork'])->name('specialists.location-and-work');
    Route::patch('specialists/{specialist}/location-and-work', [SpecialistController::class, 'updateLocationAndWork'])->name('specialists.location-and-work.update');

    Route::get('/specialists/{specialist}/education-and-documents', [SpecialistController::class, 'educationAndDocuments'])->name('specialists.education-and-documents');
    Route::get('/specialists/{specialist}/billing-and-payment-documents', [SpecialistController::class, 'billingAndPaymentDocuments'])->name('specialists.billing-and-payment-documents');
    Route::get('/specialists/{specialist}/delete-profile', [SpecialistController::class, 'deleteProfile'])->name('specialists.delete_profile');

    Route::get('/profile/password_change', [ProfileController::class, 'passwordChange'])->name('profile.password_change');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('centers/{center}/details/edit', [CenterController::class, 'editDetails'])->name('centers.details.edit');
    Route::patch('centers/{center}/details', [CenterController::class, 'updateDetails'])->name('centers.details.update');
});

Route::middleware('auth')->group(function () {

    Route::get('user/email/change', [UserController::class, 'showChangeEmailForm'])->name('user.email.change');
    Route::post('user/email/change', [UserController::class, 'changeEmail'])->name('user.email.update');
});

Route::resource('centers', CenterController::class)->only(['index', 'show']);
Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);
Route::resource('webinars', WebinarController::class)->only(['index', 'show']);
Route::resource('worksheets', WorksheetController::class)->only(['index', 'show']);
Route::resource('conferences', ConferenceController::class)->only(['index', 'show']);

Route::get('/notification-preview', [PreviewController::class, 'notification'])->name('notification-preview');
Route::get('/privacy-policy', [OtherController::class, 'privacyPolicy'])->name('privacy-policy');

Route::get('/contacts', [OtherController::class, 'contacts'])->name('contacts');

require __DIR__.'/auth.php';
