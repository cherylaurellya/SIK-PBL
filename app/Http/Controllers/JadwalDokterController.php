<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JadwalPraktik; // Pastikan Model ini ada atau buat nanti
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     */
    public function index()
    {
        // Ambil jadwal beserta data dokternya
        // Jika belum ada model JadwalPraktik, kode ini akan error.
        // Pastikan Anda sudah membuat migrasi tabel 'jadwal_praktiks'
        try {
            $jadwals = JadwalPraktik::with('dokter.user')->get();
        } catch (\Exception $e) {
            $jadwals = []; // Fallback jika tabel belum ada
        }

        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Form tambah jadwal.
     */
    public function create()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.jadwal.create', compact('dokters'));
    }

    /**
     * Simpan jadwal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPraktik::create($request->all());

        return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Hapus jadwal.
     */
    public function destroy($id)
    {
        JadwalPraktik::destroy($id);
        return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal dihapus.');
    }
    
    // Method tambahan untuk Dokter melihat jadwalnya sendiri (Sesuai routes)
    public function showJadwalSaya()
    {
        // Logika tampilkan jadwal khusus dokter yang login
        return view('dokter.jadwal'); 
    }
}