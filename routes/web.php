<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\JadwalDokterController; 
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\PembayaranController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- SMART DASHBOARD REDIRECT ---
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    } elseif ($user->role === 'perawat') {
        return redirect()->route('perawat.dashboard');
    } elseif ($user->role === 'pasien') {
        return redirect()->route('pasien.dashboard');
    }
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- PROFILE SETTINGS ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================================
// ROLE: ADMIN (Superuser)
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // CRUD Master Data
    Route::resource('pasien', PasienController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);
    Route::resource('jadwal-dokter', JadwalDokterController::class);
    
    // --- FITUR KASIR (PEMBAYARAN) ---
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/{id}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
});

// ====================================================
// ROLE: DOKTER
// ====================================================
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    
    // Dashboard Dokter
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Rekam Medis (Buat RM)
    Route::get('/rekam-medis/create/{pasien}', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis/store', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
});

// ====================================================
// ROLE: PERAWAT
// ====================================================
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    // Dashboard Perawat 
    Route::get('/dashboard', [PerawatController::class, 'dashboard'])->name('dashboard'); 

    // Cek Jadwal Dokter (Read Only)
    Route::get('jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter.index');
    
    // [FIX AKHIR: MENAMBAHKAN RUTE KELOLA ANTRIAN YANG HILANG]
    Route::get('antrian', [PerawatController::class, 'showAntrian'])->name('antrian.index');


    // Akses Kasir (Membantu Admin) - Perawat
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/{id}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
});

// ====================================================
// ROLE: PASIEN
// ====================================================
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    // Dashboard Pasien
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
    
    // Rute untuk daftar lengkap rekam medis ("Lihat Semua")
    Route::get('/rekam-medis', [RekamMedisController::class, 'indexPasien'])->name('rekam-medis.index');
});

require __DIR__.'/auth.php';