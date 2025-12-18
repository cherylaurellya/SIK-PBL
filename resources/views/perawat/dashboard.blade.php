<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BAGIAN 1: Statistik --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Halo, Ners {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500 mb-6">Selamat bertugas. Fokus pada pelayanan antrian pasien hari ini.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <div class="text-xs font-bold text-blue-500 uppercase mb-1">Antrian Hari Ini</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalAntrian ?? 0 }}</div>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <div class="text-xs font-bold text-green-500 uppercase mb-1">Selesai Diperiksa</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalSelesaiHariIni ?? 0 }}</div>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Total Pasien Terdaftar</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $totalPasienTerdaftar ?? 0 }}</div>
                        </div>
                    </div>

                    {{-- BAGIAN TOMBOL JADWAL (Link Sudah Diperbaiki) --}}
                    <h4 class="font-semibold text-gray-800 mb-4">Menu Tugas Utama</h4>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4"> 
                        
                        {{-- Perhatikan href di bawah ini sudah mengarah ke 'perawat.lihat-jadwal' --}}
                        <a href="{{ route('perawat.lihat-jadwal') }}" class="flex items-center p-4 border rounded-lg hover:bg-gray-50 transition cursor-pointer bg-indigo-50 border-indigo-200">
                            <div class="p-3 bg-indigo-100 rounded-full mr-4 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Cek Jadwal Dokter</div>
                                <div class="text-xs text-gray-500">Lihat jadwal praktik untuk menginformasikan ke pasien.</div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: Tabel Antrian Pasien --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Antrian Pasien Menunggu</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Daftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($antrian ?? [] as $pasien)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $pasien->user->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $pasien->user->email ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $pasien->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Menunggu Dokter
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'dokter')
                                                <a href="{{ route('admin.pasien.show', $pasien->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Lihat Detail
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs italic cursor-not-allowed" title="Akses Terbatas">
                                                    - Info Terbatas -
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada antrian pasien saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>