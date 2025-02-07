<?php

use App\Http\Controllers\BulletinController;
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
use App\Http\Controllers\YooKassaController;
use App\Http\Middleware\DBTransactionMiddleware;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;


Route::get('/', [OtherController::class, 'home'])->name('home');

//Route::get('/board', [OtherController::class, 'centers'])->name('board.index');

Route::get('/join', [JoinController::class, 'join'])->name('join');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/specialists/on_check', [SpecialistController::class, 'on_check'])->name('specialists.on_check');

    Route::get('/join/specialist', [JoinController::class, 'specialist'])->name('join.specialist');
    Route::get('/join/center', [JoinController::class, 'center'])->name('join.center');

    Route::resource('centers', CenterController::class)->only(['create', 'update', 'edit', 'destroy']);
    Route::resource('specialists', SpecialistController::class)->only(['create', 'update', 'edit', 'destroy']);

    Route::post('centers', [CenterController::class, 'store'])->name('centers.store')
        ->middleware([HandlePrecognitiveRequests::class, DBTransactionMiddleware::class]);

    Route::post('specialists', [SpecialistController::class, 'store'])->name('specialists.store')
        ->middleware([HandlePrecognitiveRequests::class, DBTransactionMiddleware::class]);

    Route::resource('images', ImageController::class)->only(['store']);
    Route::resource('files', FileController::class)->only(['store']);

    Route::patch('specialists/{specialist}/profile', [SpecialistController::class, 'updateProfile'])
        ->name('specialists.profile.update')
        ->middleware([HandlePrecognitiveRequests::class]);;

    Route::get('specialists/{specialist}/location-and-work', [SpecialistController::class, 'showLocationAndWork'])
        ->name('specialists.location-and-work');
    Route::patch('specialists/{specialist}/location-and-work', [SpecialistController::class, 'updateLocationAndWork'])
        ->name('specialists.location-and-work.update');

    Route::get('/specialists/{specialist}/education-and-documents', [SpecialistController::class, 'educationAndDocuments'])
        ->name('specialists.education-and-documents');
    Route::get('/users/{user}/billing-and-payment-documents', [UserController::class, 'billingAndPaymentDocuments'])
        ->name('users.billing-and-payment-documents');
    Route::get('/specialists/{specialist}/delete-profile', [SpecialistController::class, 'deleteProfile'])
        ->name('specialists.delete_profile');

    Route::get('/profile/password_change', [ProfileController::class, 'passwordChange'])->name('profile.password_change');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')
        ->middleware([HandlePrecognitiveRequests::class]);;
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('centers/{center}/details/edit', [CenterController::class, 'editDetails'])->name('centers.details.edit');
    Route::patch('centers/{center}/details', [CenterController::class, 'updateDetails'])->name('centers.details.update');

    Route::resource('bulletins', BulletinController::class)->only(['create', 'store', 'update', 'edit', 'destroy']);

    Route::post('webinars/{webinar}/toggle_subscription', [WebinarController::class, 'toggleSubscription'])->name('webinars.toggle_subscription');

    Route::get('users/{user}/webinars', [UserController::class, 'webinars'])->name('users.webinars.index');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get('/yookassa/buy-subscription/{type}', [YooKassaController::class, 'buySubscription'])
        ->name('yookassa.buy-subscription')
        ->middleware(DBTransactionMiddleware::class);

    Route::get('/payments/{payment}', [YooKassaController::class, 'paymentShow'])
        ->name('payments.show')
        ->middleware(DBTransactionMiddleware::class);

    Route::get('/payments/{payment}/cancel', [YooKassaController::class, 'paymentCancel'])
        ->name('payments.cancel')
        ->middleware(DBTransactionMiddleware::class);
});

Route::post('/yookassa/webhook', [YooKassaController::class, 'handleWebhook'])
    ->name('yookassa.webhook')
    ->middleware(DBTransactionMiddleware::class);

Route::middleware('auth')->group(function () {
    Route::get('user/email/change', [UserController::class, 'showChangeEmailForm'])->name('user.email.change');
    Route::post('user/email/change', [UserController::class, 'changeEmail'])->name('user.email.update');
});

Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

Route::resource('centers', CenterController::class)->only(['index', 'show']);
Route::resource('specialists', SpecialistController::class)->only(['index', 'show']);
Route::resource('webinars', WebinarController::class)->only(['index', 'show']);
Route::resource('worksheets', WorksheetController::class)->only(['index', 'show']);
Route::resource('conferences', ConferenceController::class)->only(['index', 'show']);
Route::resource('bulletins', BulletinController::class)->only(['index', 'show']);

Route::get('/notification-preview', [PreviewController::class, 'notification'])->name('notification-preview');
Route::get('/privacy-policy', [OtherController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/offer', [OtherController::class, 'offer'])->name('offer.show');
Route::get('/contacts', [OtherController::class, 'contacts'])->name('contacts');

require __DIR__.'/auth.php';
