<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RekamMedis;
use App\Models\Pembayaran; // Model Pembayaran
use Carbon\Carbon;

class PembayaranController extends Controller
{
    // Tampilkan daftar tagihan yang belum dibayar (Kasir/Admin)
    public function index()
    {
        // 1. Ambil Pasien yang BELUM Bayar
        $belumBayar = RekamMedis::doesntHave('pembayaran')
                        ->with(['pasien.user', 'dokter.user']) 
                        ->latest()
                        ->get();

        // 2. Ambil Riwayat Transaksi (Sudah Bayar)
        $riwayat = Pembayaran::with('rekamMedis.pasien.user')
                    ->latest()
                    ->limit(20)
                    ->get();

        // Tentukan view berdasarkan role (untuk konsistensi)
        $viewName = Auth::user()->role === 'admin' ? 'admin.pembayaran.index' : 'perawat.pembayaran.index';
        
        return view($viewName, compact('belumBayar', 'riwayat'));
    }

    // Tampilkan form pembayaran (Kasir/Admin)
    public function create($id)
    {
        // Cari data rekam medis berdasarkan ID
        $rekamMedis = RekamMedis::with(['pasien.user', 'dokter.user'])->findOrFail($id);
        
        // Tentukan view berdasarkan role
        $viewName = Auth::user()->role === 'admin' ? 'admin.pembayaran.create' : 'perawat.pembayaran.create';
        
        return view($viewName, compact('rekamMedis'));
    }

    // [STORE] Proses penyimpanan pembayaran (Kasir/Admin)
    public function store(Request $request)
    {
        // 1. Validasi Input (Menggunakan nama field dari Canvas)
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'total_biaya' => 'required|numeric|min:0', // FIX: Validasi total biaya
            'metode_pembayaran' => 'required|string', // FIX: Validasi metode pembayaran
            'uang_diterima' => 'nullable|numeric', // Opsional, untuk hitung kembalian
        ]);

        // 2. Simpan ke Database
        Pembayaran::create([
            'rekam_medis_id' => $request->rekam_medis_id,
            'total_biaya' => $request->total_biaya,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'Lunas', // Default lunas saat dibuat
            // uang_diterima TIDAK perlu disimpan jika tidak ada kolomnya di tabel pembayaran
        ]);

        // 3. Kembali ke halaman kasir yang sesuai
        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.pembayaran.index' : 'perawat.pembayaran.index';
        
        return redirect()->route($redirectRoute)->with('success', 'Pembayaran berhasil diproses!');
    }
    
    // Method untuk mencetak kwitansi
    public function print($id)
    {
        // Logika cetak kwitansi akan ada di sini
        return "Cetak Kwitansi ID: {$id}";
    }
}