<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Halo, Ners {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600">Selamat bertugas. Semoga hari Anda menyenangkan.</p>
                </div>

                {{-- STATISTIK UTAMA --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    {{-- 1. Pasien Menunggu Antrian --}}
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg shadow-sm">
                        <div class="text-sm font-bold text-blue-500 uppercase">Antrian Hari Ini</div>
                        <div class="text-3xl font-extrabold text-blue-700 mt-1">{{ $totalAntrian }}</div>
                    </div>

                    {{-- 2. Pasien Selesai Hari Ini --}}
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-lg shadow-sm">
                        <div class="text-sm font-bold text-green-500 uppercase">Selesai Diperiksa</div>
                        <div class="text-3xl font-extrabold text-green-700 mt-1">{{ $totalSelesaiHariIni }}</div>
                    </div>

                    {{-- 3. Total Pasien Terdaftar --}}
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-lg shadow-sm">
                        <div class="text-sm font-bold text-yellow-500 uppercase">Total Pasien Terdaftar</div>
                        <div class="text-3xl font-extrabold text-yellow-700 mt-1">{{ $totalPasienTerdaftar }}</div>
                    </div>
                </div>

                {{-- MENU TUGAS UTAMA --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Menu Tugas Utama</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                    {{-- Cek Jadwal Dokter (Read Only) --}}
                    <a href="{{ route('perawat.jadwal-dokter.index') }}" class="block bg-white p-6 rounded-lg shadow-md text-center hover:shadow-xl transition duration-150 border border-gray-200">
                        <span class="text-4xl text-blue-500">📅</span>
                        <div class="mt-3 font-semibold text-gray-700">Cek Jadwal Dokter</div>
                        <p class="text-xs text-gray-500">Lihat jadwal praktik hari ini.</p>
                    </a>

                    {{-- Kelola Antrian Pasien --}}
                    <a href="{{ route('perawat.antrian.index') }}" class="block bg-white p-6 rounded-lg shadow-md text-center hover:shadow-xl transition duration-150 border border-gray-200">
                        <span class="text-4xl text-green-500">👥</span>
                        <div class="mt-3 font-semibold text-gray-700">Kelola Antrian Pasien</div>
                        <p class="text-xs text-gray-500">Cek daftar pasien menunggu.</p>
                    </a>
                    
                    {{-- [DIHAPUS] Akses Pembayaran/Kasir (Hanya Admin) --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>