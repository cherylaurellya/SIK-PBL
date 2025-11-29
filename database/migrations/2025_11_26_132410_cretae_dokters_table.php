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
    // ... (Bagian Dashboard Dokter biarkan sama, skip ke bawah) ...
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user->dokter) {
            return redirect()->route('login')->with('error', 'Akun tidak valid.');
        }
        $sudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                            ->where('dokter_id', $user->dokter->id)
                            ->with('pasien.user')->get();
        $idPasienSudah = $sudahDiperiksa->pluck('pasien_id')->toArray();
        $antrian = Pasien::whereNotIn('id', $idPasienSudah)->with('user')->get();
        $jumlahSelesai = $sudahDiperiksa->count();
        $jumlahAntrian = $antrian->count();
        return view('dokter.dashboard', compact('antrian', 'sudahDiperiksa', 'jumlahSelesai', 'jumlahAntrian'));
    }

    // ==========================================================
    //  BAGIAN CRUD ADMIN (SUDAH DIPERBAIKI NAMA KOLOMNYA)
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'spesialisasi' => 'required|string', // SESUAI DATABASE
            'no_str' => 'required|string',       // SESUAI DATABASE
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            Dokter::create([
                'user_id' => $user->id,
                'spesialisasi' => $request->spesialisasi, // FIX
                'no_str' => $request->no_str,             // FIX
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
            'spesialisasi' => 'required', // FIX
            'no_str' => 'required',       // FIX
        ]);

        DB::beginTransaction();
        try {
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $dokter->user->update($dataUser);

            $dokter->update([
                'spesialisasi' => $request->spesialisasi, // FIX
                'no_str' => $request->no_str              // FIX
            ]);

            DB::commit();
            
            // Redirect ke Index
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