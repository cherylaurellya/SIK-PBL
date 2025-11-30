<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Kartu Selamat Datang --}}
            <div class="bg-gradient-to-r from-teal-500 to-blue-500 p-6 rounded-lg shadow-xl text-white mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-light">SELAMAT DATANG KEMBALI</h3>
                        <h1 class="text-3xl font-bold">{{ $user->name ?? 'Pasien' }}</h1>
                        <p class="text-sm mt-2">Semoga kondisi kesehatan Anda semakin membaik. Jangan lupa untuk selalu meminum obat sesuai anjuran dokter.</p>
                    </div>
                    <div class="p-2 bg-white bg-opacity-20 rounded-full text-xs font-semibold">
                        PASIEN AKTIF
                    </div>
                </div>
            </div>

            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Kunjungan Terakhir</div>
                        <div class="text-xl font-bold mt-1">{{ $kunjunganTerakhir->format('d M Y') ?? 'N/A' }}</div>
                    </div>
                    <span class="text-teal-500 text-2xl font-bold">📆</span>
                </div>

                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Total Pemeriksaan</div>
                        <div class="text-xl font-bold mt-1">{{ $totalPemeriksaan ?? 0 }} Kali</div>
                    </div>
                    <span class="text-green-500 text-2xl font-bold">✅</span>
                </div>

                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Status Profil</div>
                        <div class="text-xl font-bold text-yellow-600 mt-1">Lengkap</div>
                    </div>
                    <span class="text-yellow-600 text-2xl font-bold">👤</span>
                </div>
            </div>

            {{-- Riwayat Rekam Medis Ringkas --}}
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-xl font-semibold text-gray-800">Riwayat Rekam Medis</h2>
                    {{-- FIX PENTING: Tautan Lihat Semua --}}
                    <a href="{{ route('pasien.rekam-medis.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <p class="text-sm text-gray-500 mb-4">Daftar pemeriksaan dan pengobatan Anda</p>

                {{-- Tabel Ringkas --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase font-medium">
                                <th class="py-2 px-4 text-left">TANGGAL & WAKTU</th>
                                <th class="py-2 px-4 text-left">DOKTER</th>
                                <th class="py-2 px-4 text-left">DIAGNOSA</th>
                                <th class="py-2 px-4 text-left">TINDAKAN & RESEP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Asumsi Anda mengirim $riwayatTerbaru (atau sejenisnya) dari Controller --}}
                            @if($riwayatTerbaru->count())
                                @foreach($riwayatTerbaru as $rekam)
                                <tr>
                                    <td class="py-2 px-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rekam->tanggal->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $rekam->tanggal->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="py-2 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $rekam->dokter->user->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">Dokter Umum</div>
                                    </td>
                                    <td class="py-2 px-4 whitespace-nowrap text-sm text-gray-900">"{{ $rekam->diagnosis }}"</td>
                                    <td class="py-2 px-4 text-sm text-gray-900">
                                        {{ $rekam->tindakan }}<br>
                                        <span class="text-xs text-indigo-500 italic">{{ Str::limit($rekam->resep_obat, 30) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada riwayat pemeriksaan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>