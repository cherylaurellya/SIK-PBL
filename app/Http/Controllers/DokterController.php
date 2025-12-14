<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Diperlukan untuk mengambil data dokter yang sedang login
use App\Models\Dokter; 
use App\Models\User;
use App\Models\RekamMedis; // Diperlukan untuk melihat riwayat/antrian
use App\Models\JadwalPraktik; // Diperlukan untuk melihat jadwal
use App\Models\Pasien; // Diperlukan untuk data pasien
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; // Diperlukan untuk filter tanggal

class DokterController extends Controller
{
    
    public function dashboard()
    {
        // 1. Ambil ID Dokter yang sedang login
        $user = Auth::user();
        // Asumsi relasi user->dokter ada
        $dokter = Dokter::where('user_id', $user->id)->first(); 

        if (!$dokter) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        // 2. Data Statistik (Pasien yang sudah ditangani)
        $totalPasienDitangani = RekamMedis::where('dokter_id', $dokter->id)->count();

    
        $idPasienSudahDiperiksaHariIni = RekamMedis::whereDate('tanggal', Carbon::today())
                                                    ->pluck('pasien_id')
                                                    ->toArray();
        
        $antrianPasien = Pasien::whereNotIn('id', $idPasienSudahDiperiksaHariIni)
                                ->with('user')
                                ->orderBy('created_at', 'asc')
                                ->get();
        
        $totalAntrian = $antrianPasien->count();

        // 4. Jadwal Dokter Hari Ini
        $hariIni = Carbon::now()->locale('id')->dayName; 
        $jadwalHariIni = JadwalPraktik::where('dokter_id', $dokter->id)
                                    ->where('hari', $hariIni)
                                    ->first();

        return view('dokter.dashboard', compact('user', 'dokter', 'totalPasienDitangani', 'antrianPasien', 'totalAntrian', 'jadwalHariIni'));
    }


    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    // Menampilkan form tambah dokter
    public function create()
    {
        return view('admin.dokter.create');
    }
    
    // Menyimpan data dokter baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'spesialisasi' => 'nullable|string',
            'no_str' => 'required|string|unique:dokters', 
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User Login
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            // 2. Buat Data Detail Dokter
            Dokter::create([
                'user_id' => $user->id,
                'spesialisasi' => $request->spesialisasi,
                'no_str' => $request->no_str,
            ]);

            DB::commit();
            return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan Dokter:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    // Menampilkan form edit dokter
    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    // Memperbarui data dokter
    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$dokter->user_id}", 
            'spesialisasi' => 'nullable|string',
            'no_str' => "required|string|unique:dokters,no_str,{$dokter->id}", 
            'password' => 'nullable|min:8',
        ]);

        DB::beginTransaction();
        try {
            // Update User Login Data
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $dokter->user->update($dataUser);

            // Update Detail Dokter Data
            $dokter->update([
                'spesialisasi' => $request->spesialisasi,
                'no_str' => $request->no_str,
            ]);

            DB::commit();
            return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }
    
    // Menghapus data dokter dan user terkait
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->user->delete(); 
        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil dihapus.');
    }
}