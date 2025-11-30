<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- WELCOME BANNER --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border-l-8 border-emerald-500 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin {{ Auth::user()->name }}! 👑</h3>
                    <p class="text-gray-500 mt-1">Anda memiliki akses penuh untuk mengelola sistem klinik ini.</p>
                </div>
                <div class="hidden md:block">
                    <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-bold">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>

            {{-- STATS GRID (KARTU STATISTIK) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                {{-- Card 1: Pasien --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total Pasien</p>
                    <h4 class="text-4xl font-extrabold mt-2">{{ \App\Models\User::where('role', 'pasien')->count() }}</h4>
                </div>

                {{-- Card 2: Dokter --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                    </div>
                    <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider">Dokter</p>
                    <h4 class="text-4xl font-extrabold mt-2">{{ \App\Models\Dokter::count() }}</h4>
                </div>

                {{-- Card 3: Perawat --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>
                    <p class="text-purple-100 text-sm font-medium uppercase tracking-wider">Perawat</p>
                    <h4 class="text-4xl font-extrabold mt-2">{{ \App\Models\Perawat::count() }}</h4>
                </div>

                {{-- Card 4: Kunjungan --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                    </div>
                    <p class="text-orange-100 text-sm font-medium uppercase tracking-wider">Kunjungan Hari Ini</p>
                    <h4 class="text-4xl font-extrabold mt-2">{{ \App\Models\RekamMedis::whereDate('tanggal', \Carbon\Carbon::today())->count() }}</h4>
                </div>
            </div>

            {{-- MENU PENGELOLAAN (SHORTCUTS) --}}
            <h3 class="text-xl font-bold text-gray-800 mb-4">Menu Pengelolaan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                
                {{-- Shortcut 1: Dokter --}}
                <a href="{{ route('admin.dokter.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center">
                    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kelola Dokter</h4>
                    <p class="text-gray-500 text-xs mt-1">Data Spesialis & Akun</p>
                </a>

                {{-- Shortcut 2: Pasien --}}
                <a href="{{ route('admin.pasien.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kelola Pasien</h4>
                    <p class="text-gray-500 text-xs mt-1">Detail & registrasi pasien</p>
                </a>

                {{-- Shortcut 3: Perawat (INI YANG HILANG) --}}
                <a href="{{ route('admin.perawat.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center">
                    <div class="p-4 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kelola Perawat</h4>
                    <p class="text-gray-500 text-xs mt-1">Data staff & NIP</p>
                </a>

                {{-- Shortcut 4: Jadwal Dokter (INI YANG HILANG) --}}
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center">
                    <div class="p-4 bg-red-50 text-red-600 rounded-xl group-hover:bg-red-600 group-hover:text-white transition mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kelola Jadwal</h4>
                    <p class="text-gray-500 text-xs mt-1">Atur jam praktik dokter</p>
                </a>
                
                {{-- Shortcut 5: Kasir --}}
                <a href="{{ route('admin.pembayaran.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col items-center text-center">
                    <div class="p-4 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kasir / Pembayaran</h4>
                    <p class="text-gray-500 text-xs mt-1">Proses transaksi pasien</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>