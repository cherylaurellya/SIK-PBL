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
use Carbon\Carbon;

class PerawatController extends Controller
{
    // ==========================================================
    //  BAGIAN 1: DASHBOARD PERAWAT (Untuk Login sbg Perawat)
    // ==========================================================
    public function dashboard()
    {
        // Ambil ID pasien yang SUDAH diperiksa hari ini
        $idPasienSudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                                    ->pluck('pasien_id')
                                    ->toArray();

        // A. DATA ANTRIAN (Pasien yang BELUM diperiksa hari ini)
        $antrian = Pasien::whereNotIn('id', $idPasienSudahDiperiksa)
                    ->with('user')
                    ->orderBy('updated_at', 'desc')
                    ->get();

        // B. DATA SELESAI (Pasien yang SUDAH diperiksa hari ini)
        $selesai = RekamMedis::whereDate('tanggal', Carbon::today())
                    ->with('pasien.user', 'dokter.user')
                    ->get();

        // Statistik
        $totalAntrian = $antrian->count();
        $totalSelesai = $selesai->count();
        $dokterPraktek = 1; 

        return view('perawat.dashboard', compact('antrian', 'selesai', 'totalAntrian', 'totalSelesai', 'dokterPraktek'));
    }

    // ==========================================================
    //  BAGIAN 2: CRUD ADMIN (Manajemen Data Perawat)
    // ==========================================================

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
            'nomor_str' => 'required|string', // Nomor Surat Tanda Registrasi Perawat
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User Login
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'perawat',
            ]);

            // 2. Buat Data Detail Perawat
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
            'email' => "required|email|unique:users,email,$perawat->user_id",
            'nomor_str' => 'required',
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