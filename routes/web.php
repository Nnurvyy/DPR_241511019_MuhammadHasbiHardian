<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\PenggajianController;
use Illuminate\Support\Facades\Route;

// WELCOME (HOME)
Route::get('/', [HomeController::class, 'welcome']);

// dispatcher dashboard 
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');


// ADMIN ONLY
Route::middleware(['auth', 'role:Admin'])->group(function () {
     Route::get('/dashboard-admin', [DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');

    // Kelola Anggota
    Route::get('/dashboard-admin/kelola-anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/dashboard-admin/kelola-anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::put('/dashboard-admin/kelola-anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/dashboard-admin/kelola-anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');


    
    // Kelola Komponen Gaji
    Route::get('/dashboard-admin/kelola-komponen-gaji', [KomponenGajiController::class, 'index'])->name('komponen-gaji.index');
    Route::post('/dashboard-admin/kelola-komponen-gaji', [KomponenGajiController::class, 'store'])->name('komponen-gaji.store');
    Route::put('/dashboard-admin/kelola-komponen-gaji/{komponen_gaji}', [KomponenGajiController::class, 'update'])->name('komponen-gaji.update');
    Route::delete('/dashboard-admin/kelola-komponen-gaji/{komponen_gaji}', [KomponenGajiController::class, 'destroy'])->name('komponen-gaji.destroy');

    Route::get('/api/komponen-gaji-all', [KomponenGajiController::class, 'all']);

    // Kelola Penggajian
    Route::get('/dashboard-admin/kelola-penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
    Route::post('/dashboard-admin/kelola-penggajian', [PenggajianController::class, 'store'])->name('penggajian.store');
    Route::put('/dashboard-admin/kelola-penggajian/{penggajian}', [PenggajianController::class, 'update'])->name('penggajian.update');
    
    Route::put('/api/penggajian/{id_anggota}', [PenggajianController::class, 'update']);
    Route::delete('/dashboard-admin/kelola-penggajian/{id_anggota}/{id_komponen_gaji}', [PenggajianController::class, 'destroyKomponen'])->name('penggajian.destroyKomponen');

});


// PUBLIC ONLY
Route::middleware(['auth', 'role:Public'])->group(function () {
    Route::get('/dashboard-user', [DashboardController::class, 'dashboardUser'])->name('dashboard.user');

    Route::get('/dashboard-user/anggota', [AnggotaController::class, 'index2'])->name('anggota.index2');
    Route::get('/dashboard-user/penggajian', [PenggajianController::class, 'index2'])->name('penggajian.index2');

    
});



// ADMIN & PUBLIC
Route::middleware(['auth'])->group(function () {

    Route::get('/api/anggota-all', [AnggotaController::class, 'all']);
    Route::get('/api/penggajian-all', [PenggajianController::class, 'all']);
    Route::get('/api/penggajian/{id_anggota}', [PenggajianController::class, 'show']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';