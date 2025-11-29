<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokter; // Jangan lupa use Model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@klinik.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Buat Dokter
        $dokter = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dr.budi@klinik.com',
            'role' => 'dokter',
            'password' => Hash::make('password'),
        ]);
        
        // Isi data detail dokter
        Dokter::create([
            'user_id' => $dokter->id,
            'spesialisasi' => 'Umum',
            'no_str' => '1234567890',
        ]);

        // Buat Perawat
        User::create([
            'name' => 'Ners Siti',
            'email' => 'siti@klinik.com',
            'role' => 'perawat',
            'password' => Hash::make('password'),
        ]);
    }
}