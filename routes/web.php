<?php

use App\Http\Controllers\Api\MatchApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(array_key_exists($locale, config('app.supported_locales')), 404);

    session(['locale' => $locale]);

    if (auth()->check()) {
        auth()->user()->forceFill(['locale' => $locale])->save();
    }

    return back();
})->name('language.switch');

// Registration
Route::get('/register', [AuthController::class, 'showRegisterEmail'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'registerEmail'])->middleware('guest');
Route::get('/final-registration', [AuthController::class, 'showFinalRegistration'])->name('register.complete');
Route::post('/final-registration', [AuthController::class, 'completeRegistration']);

// Login / Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Password reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest');
Route::get('/set-password', [AuthController::class, 'showSetPassword'])->name('password.set');
Route::post('/set-password', [AuthController::class, 'resetPassword']);

// ─── League pages (Blade, form-based) ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/username', [ProfileController::class, 'updateUsername'])->name('profile.username');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');
    Route::get('/leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
    Route::post('/leagues', [LeagueController::class, 'store'])->name('leagues.store');
    Route::get('/leagues/join', [LeagueController::class, 'join'])->name('leagues.join');
    Route::post('/leagues/join', [LeagueController::class, 'processJoin'])->name('leagues.join.post');
    Route::get('/leagues/{id}', [LeagueController::class, 'show'])->name('leagues.show');
    Route::get('/leagues/{id}/edit', [LeagueController::class, 'edit'])->name('leagues.edit');
    Route::put('/leagues/{id}', [LeagueController::class, 'update'])->name('leagues.update');
    Route::post('/leagues/{id}/delete', [LeagueController::class, 'destroy'])->name('leagues.destroy');
    Route::get('/leagues/{id}/members', [LeagueController::class, 'showMembers'])->name('leagues.members');
    Route::post('/leagues/{id}/members/{userId}/approve', [LeagueController::class, 'approveMember'])->name('leagues.members.approve');
    Route::post('/leagues/{id}/members/{userId}/remove', [LeagueController::class, 'removeMember'])->name('leagues.members.remove');
    Route::get('/leagues/{id}/matches', [LeagueController::class, 'showMatches'])->name('leagues.matches');
});

// ─── API: predictions only (JS fetch, no page reload) ────────────────────────
Route::prefix('api')->middleware('auth')->group(function () {
    Route::put('/leagues/{id}/matches/{matchId}/prediction', [MatchApiController::class, 'upsertPrediction']);
});
