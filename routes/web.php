<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\JadwalPraktikController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RekamMedisController;




Route::get('/', function () {
    return redirect()->route('login');
});


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
    return view('dashboard'); // Default fallback
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen Master Data (CRUD)
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);
    Route::resource('pasien', PasienController::class);
    
    // Manajemen Jadwal Dokter
    Route::resource('jadwal-dokter', JadwalPraktikController::class);

    // Manajemen Pembayaran (Kasir Pusat)
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetakStruk'])->name('pembayaran.cetak');
});



Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    
    // Dashboard Dokter (Lihat Antrian)
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');

    
    Route::get('/rekam-medis/create/{pasien}', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
});



Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    
    // Dashboard Perawat (Pantau Antrian)
    Route::get('/dashboard', [PerawatController::class, 'dashboard'])->name('dashboard');

   
    Route::get('/jadwal-dokter', [PerawatController::class, 'lihatJadwal'])->name('lihat-jadwal');

    // Fitur Pembayaran di Perawat (Opsional, jika mau dipakai Leni)
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetakStruk'])->name('pembayaran.cetak');
});



Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    
    // Dashboard Pasien
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');

    
    Route::get('/riwayat-medis', [RekamMedisController::class, 'indexPasien'])->name('rekam-medis.index');
});

require __DIR__.'/auth.php';