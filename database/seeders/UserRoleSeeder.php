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
        DB::transaction(function () {

            // 1. Buat Admin
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@klinik.com'],
                [
                    'name' => 'Admin Utama',
                    'password' => Hash::make('password'), // ganti dengan password aman
                    'role' => 'admin',
                ]
            );
            Admin::firstOrCreate(['user_id' => $adminUser->id]);

            // 2. Buat Dokter
            $dokterUser = User::firstOrCreate(
                ['email' => 'dr.budi@klinik.com'],
                [
                    'name' => 'Dr. Budi Santoso',
                    'password' => Hash::make('password'),
                    'role' => 'dokter',
                ]
            );
            $dokterUser->dokter()->firstOrCreate([
                'spesialisasi' => 'Umum',       // sesuai migration
                'no_str' => '1234567890',       // sesuai migration
            ]);

            // 3. Buat Perawat
            $perawatUser = User::firstOrCreate(
                ['email' => 'siti.perawat@klinik.com'],
                [
                    'name' => 'Perawat Siti',
                    'password' => Hash::make('password'),
                    'role' => 'perawat',
                ]
            );
            $perawatUser->perawat()->firstOrCreate([
                'nomor_str' => 'STR123456',
            ]);

            // 4. Buat Pasien
            $pasienUser = User::firstOrCreate(
                ['email' => 'agus.pasien@gmail.com'],
                [
                    'name' => 'Pasien Agus',
                    'password' => Hash::make('password'),
                    'role' => 'pasien',
                ]
            );
            $pasienUser->pasien()->firstOrCreate([
                'nik' => '3510010203040001',
                'alamat' => 'Jl. Kenangan No. 10',
                'tanggal_lahir' => '1990-05-15',
            ]);
        });
    }
}