<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Config;

// Public site
Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('/apps/{id}', [AppController::class, 'show'])->name('apps.show');

// API
Route::get('/api/apps', [AppController::class, 'apiIndex']);

// Minimal auth routes (provide named "login" route so middleware redirects work)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin magic link (env-gated)
if (!empty(config('admin.magic_token'))) {
    Route::middleware('throttle:10,1')->get('/admin/magic', [AuthController::class, 'magic'])->name('admin.magic');
}

// Admin - requires auth middleware (set up Breeze/Jetstream)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [AdminController::class, 'update'])->name('update');
    Route::post('/{id}/delete', [AdminController::class, 'destroy'])->name('destroy');
    // Admin account management
    Route::get('/change-password', [AdminController::class, 'showChangePassword'])->name('showChangePassword');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('changePassword');
});
