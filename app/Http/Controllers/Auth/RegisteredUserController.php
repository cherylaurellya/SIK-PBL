<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien; // Pastikan Model Pasien di-import
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // Untuk Database Transaction

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input Standar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Gunakan Transaksi Database (Agar data User & Pasien tersimpan bersamaan)
        // Jika salah satu gagal, keduanya dibatalkan.
        DB::transaction(function () use ($request) {
            
            // A. Buat Akun User (Login)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien', // Otomatis set role jadi Pasien
            ]);

            // B. Buat Data Profil Pasien (Default/Kosong)
            // Ini PENTING agar nama pasien muncul di Tabel Admin
            Pasien::create([
                'user_id' => $user->id,
                'nik' => 'Belum Diisi',      // Nanti diedit di profil
                'alamat' => 'Belum Diisi',   // Nanti diedit di profil
                'tanggal_lahir' => now(),    // Default hari ini
            ]);

            // C. Kirim Event Registered & Login Otomatis
            event(new Registered($user));
            Auth::login($user);
        });

        // 3. Redirect ke Dashboard
        return redirect(route('dashboard', absolute: false));
    }
}