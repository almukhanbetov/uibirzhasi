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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PageBlockController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentSectionController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

// 1. Сюда мы будем переходить, чтобы улететь на оплату
Route::get('/pay-test', function () {
    return 'Здесь будет кнопка оплаты. Если вы это видите, маршрут работает.';
});

// 2. Сюда банк пришлет ответ (Result URL)
Route::post('/payment/result', function (Request $request) {
    Log::info('Freedom Pay Callback received!', $request->all());
    return response()->make('<?xml version="1.0" encoding="UTF-8"?><response><pg_status>ok</pg_status></response>', 200, ['Content-Type' => 'text/xml']);
});
Route::get('/test-telegram', function () {
    app(\App\Services\TelegramService::class)
        ->send(Auth::user()->telegram_id, 'Локально работает 🚀');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    Route::resource('deposits', AdminDepositController::class)->only(['index', 'show', 'update']);
    Route::resource('matches', AdminMatchController::class)->only(['index', 'show', 'update']);
    Route::resource('listings', AdminListingController::class);
    Route::resource('payment-sections', PaymentSectionController::class);
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'update']);

    Route::resource('pages', PageController::class);
    Route::get('pages/{page}/blocks', [PageBlockController::class, 'index'])->name('pages.blocks.index');
    Route::get('pages/{page}/blocks/create', [PageBlockController::class, 'create'])->name('pages.blocks.create');
    Route::post('pages/{page}/blocks', [PageBlockController::class, 'store'])->name('pages.blocks.store');
    Route::get('blocks/{block}/edit', [PageBlockController::class, 'edit'])->name('blocks.edit');
    Route::put('blocks/{block}', [PageBlockController::class, 'update'])->name('blocks.update');
    Route::delete('blocks/{block}', [PageBlockController::class, 'destroy'])->name('blocks.destroy');
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
Route::get('/offer', fn() => view('pages.offer'))->name('offer');
Route::get('/privacy', fn() => view('pages.privacy'))->name('privacy');
Route::get('/regions', [LocationController::class, 'regions']);
Route::get('/cities/{region}', [LocationController::class, 'cities']);
Route::get('/districts/{city}', [LocationController::class, 'districts']);
Route::get('/payment/{id}', [App\Http\Controllers\PaymentController::class,'show'])->name('payment.show');
Route::middleware('auth')->group(function () {
    Route::post('/matches/{match}/deposit', [\App\Http\Controllers\MatchDepositController::class, 'store'])
        ->name('matches.deposit');
});
Route::middleware(['auth', 'offer.accepted'])->group(function () {
    // Личный кабинет
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Недвижимость
    Route::resource('listings', ListingController::class);
    // Запросы покупателей
    // Route::resource('requests', BuyRequestController::class);
    // Депозиты / сделки
    Route::post('/matches/{id}/deposit', [DepositController::class, 'store']);
});
Route::get('/offer/accept', [OfferController::class, 'show'])
    ->middleware('auth')
    ->name('offer.accept');
Route::post('/offer/accept', [OfferController::class, 'accept'])
    ->middleware('auth');
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
