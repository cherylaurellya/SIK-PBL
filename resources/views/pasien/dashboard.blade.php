<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- 1. HERO SECTION (Gradient Card) --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl sm:rounded-2xl">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 opacity-20">
                    {{-- Icon Besar di Background --}}
                    <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-8 relative z-10 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-100 font-medium tracking-wide text-sm uppercase mb-1">Selamat Datang Kembali</p>
                            <h3 class="text-3xl font-bold">{{ Auth::user()->name }}</h3>
                            <p class="mt-2 text-blue-50 text-sm max-w-md">
                                Semoga kondisi kesehatan Anda semakin membaik. Jangan lupa untuk selalu meminum obat sesuai anjuran dokter.
                            </p>
                        </div>
                        <span class="bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold px-4 py-2 rounded-full shadow-sm">
                            PASIEN AKTIF
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. STATUS & INFO GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card Info 1 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-gray-500 text-sm font-medium">Kunjungan Terakhir</h4>
                        <p class="text-lg font-bold text-gray-800">
                            {{ isset($riwayat[0]) ? \Carbon\Carbon::parse($riwayat[0]->tanggal)->format('d M Y') : '-' }}
                        </p>
                    </div>
                </div>

                {{-- Card Info 2 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-gray-500 text-sm font-medium">Total Pemeriksaan</h4>
                        <p class="text-lg font-bold text-gray-800">{{ isset($riwayat) ? count($riwayat) : 0 }} Kali</p>
                    </div>
                </div>

                 {{-- Card Alert Profile --}}
                 <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start space-x-4">
                    <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-gray-500 text-sm font-medium">Status Profil</h4>
                        @if(Auth::user()->pasien)
                            <p class="text-sm font-bold text-green-600 mt-1">Lengkap</p>
                        @else
                            <p class="text-sm font-bold text-red-500 mt-1">Belum Lengkap</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 3. TABEL RIWAYAT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Rekam Medis</h3>
                        <p class="text-sm text-gray-500">Daftar pemeriksaan dan pengobatan Anda</p>
                    </div>
                    {{-- Tombol dummy (hiasan) --}}
                    <button class="text-sm text-blue-600 font-medium hover:text-blue-800">
                        Lihat Semua &rarr;
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Tanggal & Waktu</th>
                                <th class="px-6 py-4 font-semibold">Dokter</th>
                                <th class="px-6 py-4 font-semibold">Diagnosa</th>
                                <th class="px-6 py-4 font-semibold">Tindakan & Resep</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if(isset($riwayat) && count($riwayat) > 0)
                                @foreach($riwayat as $item)
                                    <tr class="hover:bg-blue-50/30 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }} WIB</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">Dr. {{ $item->dokter->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">Dokter Umum</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ $item->diagnosa }}
                                            </span>
                                            <p class="mt-1 text-xs text-gray-500 italic">"{{ Str::limit($item->keluhan, 40) }}"</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $item->tindakan }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-3">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada riwayat pemeriksaan medis.</p>
                                            <p class="text-xs text-gray-400 mt-1">Data akan muncul setelah Anda berobat.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>