<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Pasien;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan DB::transaction() untuk memastikan semua query berhasil
        // atau tidak sama sekali (dibatalkan/rollback)
        DB::transaction(function () {

            // 1. Buat Admin
            $adminUser = User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@klinik.com',
                'password' => Hash::make('password'), // ganti dengan password aman
                'role' => 'admin',
            ]);
            // Buat profil admin terkait
            Admin::create(['user_id' => $adminUser->id]);

            // 2. Buat Dokter
            $dokterUser = User::create([
                'name' => 'Dr. Budi',
                'email' => 'budi.dokter@klinik.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
            ]);
            // Buat profil dokter terkait
            $dokterUser->dokter()->create([
                'spesialis' => 'Umum',
            ]);

            // 3. Buat Perawat
            $perawatUser = User::create([
                'name' => 'Perawat Siti',
                'email' => 'siti.perawat@klinik.com',
                'password' => Hash::make('password'),
                'role' => 'perawat',
            ]);
            // Buat profil perawat terkait
            $perawatUser->perawat()->create([
                'nomor_str' => 'STR123456',
            ]);

            // 4. Buat Pasien
            $pasienUser = User::create([
                'name' => 'Pasien Agus',
                'email' => 'agus.pasien@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien',
            ]);
            // Buat profil pasien terkait
            $pasienUser->pasien()->create([
                'nik' => '3510010203040001',
                'alamat' => 'Jl. Kenangan No. 10',
                'tanggal_lahir' => '1990-05-15',
            ]);

        });
    }
}