<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan form untuk membuat rekam medis baru.
     */
    public function create()
    {
        // Ambil data pasien untuk dropdown
        $pasiens = Pasien::with('user')->get();
        
        return view('dokter.rekam_medis.create', compact('pasiens'));
    }

    /**
     * Menyimpan rekam medis baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string', // Nama input di form adalah 'diagnosa'
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
        ]);

        // Simpan ke database
        // PERBAIKAN: Mapping input 'diagnosa' ke kolom 'diagnosis'
        RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => Auth::user()->dokter->id,
            'tanggal' => now(),
            'keluhan' => $request->keluhan,
            'diagnosis' => $request->diagnosa, // <--- Perhatikan ini: Kiri (DB) = diagnosis, Kanan (Form) = diagnosa
            'tindakan' => $request->tindakan,
            'resep_obat' => $request->resep_obat,
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Rekam medis berhasil dibuat.');
    }
}