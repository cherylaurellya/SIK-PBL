<?php

namespace App\Http\Controllers;

use App\Models\JadwalPraktik;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalPraktikController extends Controller
{
    /**
     * Menampilkan daftar jadwal praktik.
     */
    public function index()
    {
        // Ambil semua jadwal beserta data dokternya
        $jadwals = JadwalPraktik::with('dokter.user')->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Menampilkan form tambah jadwal.
     */
    public function create()
    {
        // Kita butuh data dokter untuk dropdown pilihan
        $dokters = Dokter::with('user')->get();
        return view('admin.jadwal.create', compact('dokters'));
    }

    /**
     * Menyimpan jadwal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        JadwalPraktik::create($request->all());

        return redirect()->route('admin.jadwal-dokter.index')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
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
     * Mengupdate jadwal di database.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPraktik::findOrFail($id);

        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal-dokter.index')
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy($id)
    {
        $jadwal = JadwalPraktik::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-dokter.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}