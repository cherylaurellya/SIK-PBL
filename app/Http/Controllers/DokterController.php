<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;
use App\Models\User;
use App\Models\RekamMedis;
use App\Models\Pasien;
use Carbon\Carbon;

class DokterController extends Controller
{
    // ==========================================================
    //  BAGIAN 1: DASHBOARD DOKTER (Untuk Login sbg Dokter)
    // ==========================================================
    public function dashboard()
    {
        $user = Auth::user();
        
        // Cek validasi dokter
        if (!$user->dokter) {
            return redirect()->route('login')->with('error', 'Akun tidak valid sebagai dokter.');
        }

        // Ambil pasien yang SUDAH diperiksa hari ini
        $sudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                            ->where('dokter_id', $user->dokter->id)
                            ->with('pasien.user')
                            ->get();

        $idPasienSudah = $sudahDiperiksa->pluck('pasien_id')->toArray();

        // Ambil pasien yang BELUM diperiksa (Antrian)
        // Asumsi: Semua pasien yang tidak ada di rekam medis hari ini adalah antrian
        // (Nanti bisa diperbaiki logikanya dengan tabel pendaftaran khusus jika ada)
        $antrian = Pasien::whereNotIn('id', $idPasienSudah)
                    ->with('user')
                    ->get();

        $jumlahSelesai = $sudahDiperiksa->count();
        $jumlahAntrian = $antrian->count();

        return view('dokter.dashboard', compact('antrian', 'sudahDiperiksa', 'jumlahSelesai', 'jumlahAntrian'));
    }

    // ==========================================================
    //  BAGIAN 2: CRUD ADMIN (Manajemen Data Dokter)
    // ==========================================================

    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        // PERBAIKAN: Menyesuaikan nama input dengan View (sip & spesialis)
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'spesialis' => 'required|string', // Ganti spesialisasi jadi spesialis
            'sip' => 'required|string',       // Ganti no_str jadi sip
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
                'spesialis' => $request->spesialis, // Sesuaikan
                'sip' => $request->sip,             // Sesuaikan
            ]);

            DB::commit();
            return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$dokter->user_id",
            'spesialis' => 'required', // Sesuaikan
            'sip' => 'required',       // Sesuaikan
        ]);

        DB::beginTransaction();
        try {
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $dokter->user->update($dataUser);

            $dokter->update([
                'spesialis' => $request->spesialis, // Sesuaikan
                'sip' => $request->sip              // Sesuaikan
            ]);

            DB::commit();
            
            // Redirect ke INDEX (Tabel), bukan kembali ke form edit
            return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->user->delete(); 
        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter dihapus.');
    }
}