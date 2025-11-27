<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use App\Models\RekamMedis; // Import Model RekamMedis
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    // ==========================================
    // BAGIAN UNTUK PASIEN (Dashboard)
    // ==========================================
    public function dashboard()
    {
        $user = Auth::user();

        // Pastikan user punya data pasien
        if (!$user->pasien) {
             return view('pasien.dashboard', ['riwayat' => []]);
        }

        // Ambil riwayat rekam medis milik pasien ini
        $riwayat = RekamMedis::where('pasien_id', $user->pasien->id)
                    ->with('dokter.user')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('pasien.dashboard', compact('riwayat'));
    }

    // ==========================================
    // BAGIAN UNTUK ADMIN (CRUD Data Pasien)
    // ==========================================
    
    // Menampilkan semua pasien (Admin)
    public function index()
    {
        $pasiens = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // Menampilkan form tambah pasien (Admin)
    public function create()
    {
        return view('admin.pasien.create');
    }

    // Menyimpan pasien baru (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|size:16|unique:pasiens',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            $user->pasien()->create([
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $userId = $pasien->user_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,$userId",
            'nik' => "required|string|size:16|unique:pasiens,nik,$pasien->id",
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'password' => 'nullable|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            $userData = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $pasien->user->update($userData);

            $pasien->update([
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Data berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            $pasien->user->delete();
            return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }
}