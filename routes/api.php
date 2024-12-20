<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/stats', [OtherController::class, 'stat'])->name('stat');
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', [AuthController::class, 'user'])->name('user');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update')
        ->middleware([HandlePrecognitiveRequests::class]);
    Route::post('/users/{user}/photos', [UserController::class, 'updatePhoto'])->name('users.photos.update');

    Route::get('/specialists/on_check', [SpecialistController::class, 'on_check'])->name('specialists.on_check');

    Route::resource('centers', CenterController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
    Route::resource('specialists', SpecialistController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);
    Route::resource('bulletins', BulletinController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);

    Route::resource('centers', CenterController::class)->only(['index', 'show']);
    Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);
    Route::resource('bulletins', BulletinController::class)->only(['index', 'show']);

    Route::put('/specialists/{specialist}/approve', [SpecialistController::class, 'approve'])->name('specialists.approve');
    Route::put('/specialists/{specialist}/reject', [SpecialistController::class, 'reject'])->name('specialists.reject');

    Route::post('/specialists/{specialist}/photos', [SpecialistController::class, 'updatePhoto'])->name('specialists.update_photo');
    Route::patch('/specialists/{specialist}/location-and-work', [SpecialistController::class, 'updateLocationAndWork'])
        ->name('specialists.location-and-work.update');

    Route::put('/centers/{center}/approve', [CenterController::class, 'approve'])->name('centers.approve');
    Route::put('/centers/{center}/reject', [CenterController::class, 'reject'])->name('centers.reject');

    Route::put('/bulletins/{bulletin}/approve', [BulletinController::class, 'approve'])->name('bulletins.approve');
    Route::put('/bulletins/{bulletin}/reject', [BulletinController::class, 'reject'])->name('bulletins.reject');

    Route::get('webinars/upcoming', [WebinarController::class, 'upcoming'])->name('webinars.upcoming');
    Route::get('webinars/ended', [WebinarController::class, 'ended'])->name('webinars.ended');
    Route::resource('webinars', WebinarController::class)->only(['show']);
    Route::post('webinars', [WebinarController::class, 'store'])->name('webinars.store')
        ->middleware([HandlePrecognitiveRequests::class]);
    Route::patch('webinars/{webinar}', [WebinarController::class, 'update'])->name('webinars.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::resource('worksheets', WorksheetController::class)->only(['index', 'show']);
    Route::post('worksheets', [WorksheetController::class, 'store'])->name('worksheets.store')
        ->middleware([HandlePrecognitiveRequests::class]);
    Route::patch('worksheets/{worksheet}', [WorksheetController::class, 'update'])->name('worksheets.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get('conferences/upcoming', [ConferenceController::class, 'upcoming'])->name('conferences.upcoming');
    Route::get('conferences/ended', [ConferenceController::class, 'ended'])->name('conferences.ended');
    Route::resource('conferences', ConferenceController::class)->only(['index', 'show']);
    Route::post('conferences', [ConferenceController::class, 'store'])->name('conferences.store')
        ->middleware([HandlePrecognitiveRequests::class]);
    Route::patch('conferences/{conference}', [ConferenceController::class, 'update'])->name('conferences.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::resource('images', ImageController::class)->only(['store']);
    Route::resource('files', FileController::class)->only(['store']);
});
