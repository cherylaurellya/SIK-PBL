<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;
use App\Models\User;
use App\Models\RekamMedis; // Diperlukan untuk dashboard
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    // ==========================================================
    // BAGIAN 1: DASHBOARD PASIEN (Khusus Role Pasien)
    // ==========================================================
    
    public function dashboard()
    {
        $user = Auth::user();
        // Ambil data detail Pasien. Gagal jika user tidak memiliki entry di tabel pasiens
        $pasien = Pasien::where('user_id', $user->id)->firstOrFail(); 
        
        // 1. Ambil Riwayat Medis Lengkap
        $riwayatMedis = RekamMedis::where('pasien_id', $pasien->id)
                                    ->with('dokter.user')
                                    ->orderBy('tanggal', 'desc')
                                    ->get();

        // 2. Hitung Statistik
        $totalPemeriksaan = $riwayatMedis->count();
        
        // Menghitung kunjungan terakhir
        $kunjunganTerakhir = $riwayatMedis->first() 
                                ? Carbon::parse($riwayatMedis->first()->tanggal) 
                                : null;

        // 3. Ambil Riwayat Terbaru (Untuk ditampilkan ringkas di dashboard)
        $riwayatTerbaru = $riwayatMedis->take(3);

        // 4. Kirim data ke View
        return view('pasien.dashboard', compact(
            'user', 
            'pasien',
            'totalPemeriksaan',
            'kunjunganTerakhir',
            'riwayatTerbaru'
        ));
    }
    
    // ==========================================================
    // BAGIAN 2: CRUD ADMIN (Manajemen Data Pasien)
    // ==========================================================
    
    // Tampilkan daftar pasien (Admin)
    public function index()
    {
        $pasiens = Pasien::with('user')->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // [CREATE] Tampilkan form tambah pasien (Admin)
    // METHOD INI HANYA BOLEH DIPANGGIL OLEH RUTE ADMIN.
    public function create()
    {
        return view('admin.pasien.create');
    }

    // [STORE] Simpan data pasien baru (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'nik' => 'required|string|unique:pasiens',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User Login (Role Pasien)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            // 2. Buat Data Detail Pasien
            Pasien::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            
            // Redirect ke halaman Admin Index (Karena hanya Admin yang memanggil store ini sekarang)
            return redirect()->route('admin.pasien.index')->with('success', 'Pasien baru berhasil didaftarkan oleh Admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Penting: Jika ada error SQL/DB lain, akan ditangkap dan dikembalikan
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    // Tampilkan detail pasien (Admin)
    public function show(Pasien $pasien)
    {
        // Ambil riwayat medis lengkap pasien
        $riwayatMedis = RekamMedis::where('pasien_id', $pasien->id)
                                    ->with('dokter.user')
                                    ->orderBy('tanggal', 'desc')
                                    ->get();
                                    
        return view('admin.pasien.show', compact('pasien', 'riwayatMedis'));
    }

    // Tampilkan form edit pasien (Admin)
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    // Update data pasien (Admin)
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi dan logika update data pasien
        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$pasien->user_id}",
            'nik' => "required|string|unique:pasiens,nik,{$pasien->id}",
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'password' => 'nullable|min:8',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $pasien->user->update($dataUser);

            // Update Detail Pasien
            $pasien->update($request->only('nik', 'alamat', 'tanggal_lahir'));

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Data Pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }
    
    // Hapus data pasien (Admin)
    public function destroy(Pasien $pasien)
    {
        $pasien->user->delete(); // Cascade delete akan menghapus Pasien
        return redirect()->route('admin.pasien.index')->with('success', 'Data Pasien berhasil dihapus.');
    }
}