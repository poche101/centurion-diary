<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\ScriptureController;
use App\Http\Controllers\SoulController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', fn () => redirect()->route('login'));

// Auth (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', fn () => view('welcome'))->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Push Subscriptions ─────────────────────────────────────────
    Route::post('/push/subscribe',     [PushSubscriptionController::class, 'store']);
    Route::delete('/push/unsubscribe', [PushSubscriptionController::class, 'destroy']);

    // ── Prayer ─────────────────────────────────────────────────────
    Route::prefix('prayer')->name('prayer.')->group(function () {
        Route::get('/',               [PrayerController::class, 'index'])->name('index');
        Route::post('/',              [PrayerController::class, 'store'])->name('store');
        Route::post('/quick-log',     [PrayerController::class, 'quickLog'])->name('quick-log');
        Route::delete('/{prayerLog}', [PrayerController::class, 'destroy'])->name('destroy');
    });

    // ── Soul Winning ───────────────────────────────────────────────
    Route::prefix('souls')->name('souls.')->group(function () {
        Route::get('/',          [SoulController::class, 'index'])->name('index');
        Route::post('/',         [SoulController::class, 'store'])->name('store');
        Route::patch('/{soul}',  [SoulController::class, 'update'])->name('update');
        Route::delete('/{soul}', [SoulController::class, 'destroy'])->name('destroy');
    });

    // ── Giving ─────────────────────────────────────────────────────
    Route::prefix('giving')->name('giving.')->group(function () {
        Route::get('/',               [GivingController::class, 'index'])->name('index');
        Route::post('/',              [GivingController::class, 'store'])->name('store');
        Route::delete('/{givingLog}', [GivingController::class, 'destroy'])->name('destroy');
    });

    // ── Leaderboard ────────────────────────────────────────────────
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    // ── Daily Scripture ────────────────────────────────────────────
    Route::get('/scripture', [ScriptureController::class, 'index'])->name('scripture');

    // ── Profile ────────────────────────────────────────────────────
    Route::get('/profile',            [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(\App\Http\Middleware\IsAdmin::class)
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // Scripture CMS
            Route::post('/scripture',               [AdminController::class, 'storeScripture'])->name('scripture.store');
            Route::delete('/scripture/{scripture}', [AdminController::class, 'destroyScripture'])->name('scripture.destroy');

            // Bulk notifications
            Route::post('/notify', [AdminController::class, 'sendNotification'])->name('notify');

            // User management
            Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
        });

}); // ← closes Route::middleware('auth')
