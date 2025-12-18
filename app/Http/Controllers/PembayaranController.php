<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // MENAMPILKAN HALAMAN KASIR
    public function index()
    {
        // 1. Ambil data Rekam Medis yang BELUM punya data Pembayaran (Tagihan Baru)
        // Syarat: Harus ada relasi 'pembayaran' di model RekamMedis
        $tagihanBelumLunas = RekamMedis::doesntHave('pembayaran')
                                       ->with(['pasien.user', 'dokter.user'])
                                       ->orderBy('tanggal', 'desc')
                                       ->get();

        // 2. Ambil data Pembayaran yang SUDAH ada (Riwayat Lunas)
        $riwayatPembayaran = Pembayaran::with(['rekamMedis.pasien.user'])
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        return view('admin.pembayaran.index', compact('tagihanBelumLunas', 'riwayatPembayaran'));
    }

    // PROSES BAYAR (Update/Simpan Pembayaran)
    public function update(Request $request, $id)
    {
        // Validasi input biaya
        $request->validate([
            'total_biaya' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            // $id di sini adalah ID Rekam Medis yang mau dibayar
            
            // Generate Nomor Transaksi Unik (TRX-TahunBulanDetik-Random)
            $noTransaksi = 'TRX-' . date('YmdHis') . '-' . rand(100, 999);

            // Simpan ke tabel pembayarans
            Pembayaran::create([
                'rekam_medis_id' => $id,
                'no_transaksi'   => $noTransaksi,
                'total_biaya'    => $request->total_biaya,
                'status'         => 'lunas', // Langsung lunas saat dibayar di kasir
                'metode_pembayaran' => 'tunai', // Default tunai
            ]);
        });

        return back()->with('success', 'Pembayaran berhasil diproses!');
    }

    // CETAK STRUK
    public function cetakStruk($id)
    {
        // HAPUS 'rekamMedis.resepObat' dari dalam array with() biar tidak error
        $pembayaran = Pembayaran::with(['rekamMedis.pasien.user', 'rekamMedis.dokter.user'])
                                ->findOrFail($id);
        
        return view('admin.pembayaran.cetak', compact('pembayaran'));
    }
}