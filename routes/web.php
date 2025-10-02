<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// WELCOME (HOME)
Route::get('/', [HomeController::class, 'welcome']);

// dispatcher dashboard 
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:Admin'])->group(function () {
     Route::get('/dashboard-admin', [DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');
});

Route::middleware(['auth', 'role:Public'])->group(function () {
    Route::get('/dashboard-user', [DashboardController::class, 'dashboardUser'])->name('dashboard.user');
});

// PROFILE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';