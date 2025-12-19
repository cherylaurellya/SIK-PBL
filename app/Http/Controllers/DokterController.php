<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Dokter; 
use App\Models\User;
use App\Models\RekamMedis; 
use App\Models\JadwalPraktik; 
use App\Models\Pasien; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 

class DokterController extends Controller
{
    
    public function dashboard()
    {
        $user = Auth::user();
        
        $dokter = Dokter::where('user_id', $user->id)->first(); 

        if (!$dokter) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $totalPasienDitangani = RekamMedis::where('dokter_id', $dokter->id)->count();

    
        $idPasienSudahDiperiksaHariIni = RekamMedis::whereDate('tanggal', Carbon::today())
                                                    ->pluck('pasien_id')
                                                    ->toArray();
        
        $antrianPasien = Pasien::whereNotIn('id', $idPasienSudahDiperiksaHariIni)
                                ->with('user')
                                ->orderBy('created_at', 'asc')
                                ->get();
        
        $totalAntrian = $antrianPasien->count();

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
            'spesialisasi' => 'nullable|string',
            'no_str' => 'required|string|unique:dokters', 
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

    
    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    
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
            
            $dataUser = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }
            $dokter->user->update($dataUser);

            
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
    
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->user->delete(); 
        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil dihapus.');
    }
}