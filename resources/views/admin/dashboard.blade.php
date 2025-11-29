<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. HEADER --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 flex justify-between items-center border-l-4 border-purple-500">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Halo, Ners {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-500 text-sm mt-1">Selamat bertugas. Utamakan pelayanan prima kepada pasien.</p>
                </div>
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    Staff Medis
                </span>
            </div>

            {{-- 2. MENU GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- MENU 1: JADWAL DOKTER --}}
                <a href="{{ route('perawat.jadwal-dokter.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center cursor-pointer">
                    <div class="p-4 bg-indigo-50 text-indigo-600 rounded-full mb-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Jadwal Dokter</h4>
                    <p class="text-xs text-gray-500 mt-2">Cek siapa dokter yang praktik hari ini.</p>
                </a>

                {{-- MENU 2: INPUT TTV (Vital Signs) --}}
                {{-- Kita arahkan ke dashboard dokter sementara atau buat route baru nanti --}}
                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] px-2 py-1 rounded-bl-lg font-bold">UTAMA</div>
                    <div class="p-4 bg-pink-50 text-pink-600 rounded-full mb-4 group-hover:bg-pink-600 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Pemeriksaan Awal</h4>
                    <p class="text-xs text-gray-500 mt-2">Cek Tensi, Suhu, & Berat Badan Pasien.</p>
                </div>

                {{-- MENU 3: PEMBAYARAN / KASIR --}}
                {{-- Karena PDF bilang ada fitur Pembayaran & Resep --}}
                <a href="{{ route('admin.pembayaran.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center cursor-pointer">
                    <div class="p-4 bg-green-50 text-green-600 rounded-full mb-4 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Kasir & Obat</h4>
                    <p class="text-xs text-gray-500 mt-2">Proses pembayaran & pengambilan obat.</p>
                </a>

            </div>

             {{-- 3. TABEL PASIEN HARI INI --}}
             <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="font-bold text-lg text-gray-800 mb-4">Antrian Pasien Hari Ini</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Data Dummy (Nanti bisa diganti query real) --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Budi Santoso</div>
                                        <div class="text-xs text-gray-500">Umum</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu TTV
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 text-xs font-bold">Periksa TTV</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>