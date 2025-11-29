<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. STATISTICS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                {{-- Card Total Pasien --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Pasien</div>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">
                        {{ \App\Models\User::where('role', 'pasien')->count() }}
                    </div>
                </div>

                {{-- Card Total Dokter --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Dokter</div>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">
                        {{ \App\Models\User::where('role', 'dokter')->count() }}
                    </div>
                </div>

                {{-- Card Total Perawat --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Perawat</div>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">
                        {{ \App\Models\User::where('role', 'perawat')->count() }}
                    </div>
                </div>

                {{-- Card Total User --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Akun</div>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">
                        {{ \App\Models\User::count() }}
                    </div>
                </div>
            </div>

            {{-- 2. QUICK ACTIONS (MENU CEPAT) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Menu Kelola Data</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        {{-- Tombol Kelola Dokter --}}
                        <a href="{{ route('admin.dokter.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 group-hover:text-blue-700">Data Dokter</h5>
                                    <p class="font-normal text-sm text-gray-700">Tambah, Edit, & Hapus Dokter.</p>
                                </div>
                                <div class="text-blue-500 group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                        {{-- Tombol Kelola Pasien --}}
                        <a href="{{ route('admin.pasien.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition cursor-pointer shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 group-hover:text-green-700">Data Pasien</h5>
                                    <p class="font-normal text-sm text-gray-700">Lihat & Kelola data pasien.</p>
                                </div>
                                <div class="text-green-500 group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                        {{-- Tombol Kelola Jadwal --}}
                        <a href="{{ route('admin.jadwal-dokter.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition cursor-pointer shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 group-hover:text-purple-700">Jadwal Praktik</h5>
                                    <p class="font-normal text-sm text-gray-700">Atur hari & jam kerja dokter.</p>
                                </div>
                                <div class="text-purple-500 group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>