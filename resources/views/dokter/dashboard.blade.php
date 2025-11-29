<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. HEADER SAMBUTAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Halo, Dr. {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Selamat bertugas. Berikut adalah antrian pasien hari ini.</p>
                </div>
            </div>

            {{-- 2. KARTU STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Card Antrian --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg shadow-sm flex justify-between items-center">
                    <div>
                        <div class="text-sm font-bold text-blue-500 uppercase">Pasien Menunggu</div>
                        <div class="text-3xl font-extrabold text-blue-700 mt-1">{{ $jumlahAntrian }}</div>
                    </div>
                    <div class="p-3 bg-blue-200 rounded-full text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Card Selesai --}}
                <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-lg shadow-sm flex justify-between items-center">
                    <div>
                        <div class="text-sm font-bold text-green-500 uppercase">Selesai Diperiksa</div>
                        <div class="text-3xl font-extrabold text-green-700 mt-1">{{ $jumlahSelesai }}</div>
                    </div>
                    <div class="p-3 bg-green-200 rounded-full text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- 3. TABEL ANTRIAN (KOLOM KIRI - LEBIH LEBAR) --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="font-bold text-lg text-gray-800 mb-4">Antrian Pasien (Belum Diperiksa)</h4>
                        
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
                                    @forelse($antrian as $pasien)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $pasien->user->name ?? 'Tanpa Nama' }}</div>
                                                <div class="text-xs text-gray-500">NIK: {{ $pasien->nik }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Tombol Periksa --}}
                                                <a href="{{ route('dokter.rekam-medis.create', ['pasien_id' => $pasien->id]) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
                                                    Periksa
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada antrian pasien saat ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 4. TABEL RIWAYAT HARI INI (KOLOM KANAN) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="font-bold text-lg text-gray-800 mb-4">Selesai Hari Ini</h4>
                        
                        <div class="overflow-y-auto max-h-96">
                            <ul class="divide-y divide-gray-200">
                                @forelse($sudahDiperiksa as $rm)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $rm->pasien->user->name ?? 'Pasien' }}
                                                </p>
                                                <p class="text-xs text-gray-500 truncate">
                                                    {{ Str::limit($rm->diagnosa, 25) }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($rm->tanggal)->format('H:i') }}
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-4 text-center text-sm text-gray-500">
                                        Belum ada pasien selesai diperiksa.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>