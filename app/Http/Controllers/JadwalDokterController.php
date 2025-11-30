<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JadwalPraktik; 
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     */
    public function index()
    {
        try {
            // Mengambil jadwal praktiks beserta data dokternya
            $jadwals = JadwalPraktik::with('dokter.user')->get();
        } catch (\Exception $e) {
            $jadwals = []; 
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
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:1,0',
        ]);

        JadwalPraktik::create($request->all());

        return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit($id)
    {
        $jadwal = JadwalPraktik::findOrFail($id);
        $dokters = Dokter::with('user')->get();
        
        return view('admin.jadwal.edit', compact('jadwal', 'dokters'));
    }

    /**
     * [PERBAIKAN FOKUS STATUS] Memperbarui jadwal.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:1,0',
        ]);
        
        $jadwal = JadwalPraktik::findOrFail($id);
        
        // PENTING: Memastikan status di-cast ke integer sebelum disimpan.
        // Ini mengatasi masalah di mana string "1" tidak dikonversi dengan benar.
        $validatedData['status'] = (int) $validatedData['status'];
        
        $jadwal->update($validatedData);

        return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal.
     */
    public function destroy($id)
    {
        JadwalPraktik::destroy($id);
        return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal dihapus.');
    }
    
    /**
     * Method tambahan untuk Dokter melihat jadwalnya sendiri (Sesuai routes)
     */
    public function showJadwalSaya()
    {
        // Logika tampilkan jadwal khusus dokter yang login
        return view('dokter.jadwal'); 
    }
}