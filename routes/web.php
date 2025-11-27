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

// --- PROFILE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    
    Route::resource('pasien', PasienController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);

    // PERBAIKAN DI SINI: Tanda komentar // sudah dihapus
    Route::resource('jadwal-dokter', JadwalDokterController::class);
    
    // Route::resource('pembayaran', PembayaranController::class); // Aktifkan jika controller sudah ada
});

// --- DOKTER ---
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('jadwal', [JadwalDokterController::class, 'showJadwalSaya'])->name('jadwal.saya');
    Route::get('rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
});

// --- PERAWAT ---
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [PerawatController::class, 'dashboard'])->name('dashboard');
    Route::get('jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter.index');
});

// --- PASIEN ---
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
});

require __DIR__.'/auth.php';