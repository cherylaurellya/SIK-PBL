<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Perawat;
use App\Models\User;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\JadwalPraktik; 
use Carbon\Carbon;

class PerawatController extends Controller
{
   
    public function dashboard()
    {
        // 1. Ambil ID pasien yang SUDAH diperiksa hari ini
        $idPasienSudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                                            ->pluck('pasien_id')
                                            ->toArray();

        // 2. DATA ANTRIAN (Pasien yang BELUM diperiksa)
        $antrian = Pasien::whereNotIn('id', $idPasienSudahDiperiksa)
                         ->with('user')
                         ->orderBy('updated_at', 'desc')
                         ->get();

        // 3. DATA SELESAI (Pasien yang SUDAH diperiksa)
        $selesai = RekamMedis::whereDate('tanggal', Carbon::today())->get();

        // 4. Statistik
        $totalAntrian = $antrian->count();
        $totalSelesaiHariIni = $selesai->count();
        $totalPasienTerdaftar = Pasien::count(); 

        return view('perawat.dashboard', compact('antrian', 'totalAntrian', 'totalSelesaiHariIni', 'totalPasienTerdaftar'));
    }

    
    public function lihatJadwal()
    {
        
        $jadwals = JadwalPraktik::with('dokter.user')->get();
        
        
        return view('admin.jadwal.index', compact('jadwals'));
    }
    
    public function showAntrian()
    {
        $idPasienSudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                                            ->pluck('pasien_id')
                                            ->toArray();

        $antrianPasien = Pasien::whereNotIn('id', $idPasienSudahDiperiksa)
                          ->with('user')
                          ->orderBy('updated_at', 'desc')
                          ->get();
                          
        return view('perawat.antrian.index', compact('antrianPasien'));
    }
    
    

    public function index()
    {
        $perawats = Perawat::with('user')->get();
        return view('admin.perawat.index', compact('perawats'));
    }

    public function create()
    {
        return view('admin.perawat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'nomor_str' => 'required|string|unique:perawats', 
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'perawat',
            ]);

            Perawat::create([
                'user_id' => $user->id,
                'nomor_str' => $request->nomor_str,
            ]);

            DB::commit();
            return redirect()->route('admin.perawat.index')->with('success', 'Perawat berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $perawat = Perawat::with('user')->findOrFail($id);
        return view('admin.perawat.edit', compact('perawat'));
    }

    public function update(Request $request, $id)
    {
        $perawat = Perawat::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$perawat->user_id}",
            'nomor_str' => "required|unique:perawats,nomor_str,{$perawat->id}",
            'password' => 'nullable|min:8',
        ]);

        DB::beginTransaction();
        try {
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $perawat->user->update($dataUser);

            $perawat->update([
                'nomor_str' => $request->nomor_str
            ]);

            DB::commit();
            return redirect()->route('admin.perawat.index')->with('success', 'Data Perawat diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $perawat = Perawat::findOrFail($id);
        $perawat->user->delete(); 
        return redirect()->route('admin.perawat.index')->with('success', 'Data Perawat dihapus.');
    }
}