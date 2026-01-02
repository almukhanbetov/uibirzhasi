<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AdminMatchController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Auth;

// Route::middleware('auth')->prefix('draft')->name('draft.')->group(function () {
//     Route::post('save', [DraftController::class, 'save'])->name('save');
//     Route::post('upload-photo', [DraftController::class, 'uploadPhoto'])->name('upload-photo');
//     Route::delete('delete-photo', [DraftController::class, 'deletePhoto'])->name('delete-photo');
// });
Route::get('/test-telegram', function () {
    app(\App\Services\TelegramService::class)
        ->send(Auth::user()->telegram_id, 'Локально работает 🚀');
});
Route::post('/telegram/webhook', [TelegramWebhookController::class, 'handle']);
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/sale', [WelcomeController::class, 'sale'])->name('welcome.sale');
Route::get('/buy', [WelcomeController::class, 'buy'])->name('welcome.buy');
Route::get('/new', [NewController::class, 'index'])->name('new');
Route::get('/test', [TestController::class, 'index'])->name('test');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
Route::get('/listings/show/{id}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/listings/ajax', [ListingController::class, 'ajaxSearch'])->name('listings.ajax');
Route::get('/profile/create', [ListingController::class, 'create'])->name('listing.create');
Route::post('/profile/create', [ListingController::class, 'store'])->name('listing.store');

Route::get('/regions', [LocationController::class, 'regions']);
Route::get('/cities/{region}', [LocationController::class, 'cities']);
Route::get('/districts/{city}', [LocationController::class, 'districts']);
Route::middleware('auth')->group(function () {
    Route::post('/matches/{match}/deposit', [\App\Http\Controllers\MatchDepositController::class, 'store'])
        ->name('matches.deposit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('deposits', AdminDepositController::class)->only(['index', 'show', 'update']);
    Route::resource('matches', AdminMatchController::class)->only(['index', 'show', 'update']);
    Route::resource('listings', AdminListingController::class);
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'update']);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile/matches', [MatchController::class, 'index'])->name('profile.matches.index');
    Route::get('/matches/{match}', [MatchController::class, 'show'])->name('profile.matches.show');
    Route::post('/listings',        [ListingController::class, 'store'])->name('listings.store');
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{listing}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{listing}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{listing}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{listing}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    //    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/listings/photos/{photo}', [ProfileController::class, 'deletePhoto'])->name('profile.listings.photos.delete');

    //    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
