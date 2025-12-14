<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Resep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * [BARU] Menampilkan daftar lengkap riwayat medis untuk pasien yang sedang login.
     */
    public function indexPasien()
    {
        // 1. Ambil data pasien yang sedang login
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->firstOrFail(); 
        
       
        $riwayatMedis = RekamMedis::where('pasien_id', $pasien->id)
                                    ->with('dokter.user')
                                    ->orderBy('tanggal', 'desc')
                                    ->get();

        // 3. Tampilkan view daftar riwayat
        return view('pasien.rekam_medis.index', compact('riwayatMedis', 'user'));
    }

    /**
     * Menampilkan form untuk membuat rekam medis baru untuk Pasien tertentu.
     */
    public function create(Pasien $pasien)
    {
        // ... (kode create Dokter tetap sama) ...
        $dokter = Auth::user()->dokter; 

        if (!$dokter) {
             return back()->withErrors(['error' => 'Data Dokter (Role Dokter) yang sedang login tidak ditemukan.']);
        }

        return view('dokter.rekam_medis.create', compact('pasien', 'dokter'));
    }

    /**
     * Menyimpan rekam medis baru ke database.
     */
    public function store(Request $request)
    {
        // ... (kode store tetap sama) ...
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string', 
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
        ]);

        RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => Auth::user()->dokter->id,
            'tanggal' => now(),
            'keluhan' => $request->keluhan,
            'diagnosis' => $request->diagnosa, 
            'tindakan' => $request->tindakan,
            'resep_obat' => $request->resep_obat,
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Rekam medis berhasil dibuat.');
    }
}