<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. TAGIHAN MENUNGGU PEMBAYARAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-red-300">
                <div class="p-6 bg-white">
                    <div class="flex items-center text-red-600 mb-4">
                        <span class="text-xl mr-2">ⓘ</span>
                        <h3 class="font-semibold">Tagihan Menunggu Pembayaran</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        @if($belumBayar->isEmpty())
                            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                Tidak ada tagihan yang menunggu pembayaran hari ini.
                            </div>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pasien</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Dokter</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Diagnosis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- FIX: Menggunakan perulangan untuk menampilkan daftar --}}
                                    @foreach ($belumBayar as $rekamMedis) 
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $rekamMedis->pasien->user->name ?? 'Pasien' }}</div>
                                                <div class="text-xs text-gray-500">{{ Carbon\Carbon::parse($rekamMedis->tanggal)->format('d M Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $rekamMedis->dokter->user->name ?? 'Dokter' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-bold">
                                                {{ $rekamMedis->diagnosis }} 
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{-- Menentukan rute berdasarkan role yang sedang login --}}
                                                @php
                                                    $routeName = Auth::user()->role === 'admin' ? 'admin.pembayaran.create' : 'perawat.pembayaran.create';
                                                @endphp
                                                <a href="{{ route($routeName, $rekamMedis->id) }}" class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold">
                                                    BAYAR SEKARANG
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. RIWAYAT TRANSAKSI TERAKHIR (Menggunakan variabel $riwayat) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-300">
                 <div class="p-6 bg-white">
                    <div class="flex items-center text-green-600 mb-4">
                        <span class="text-xl mr-2">✅</span>
                        <h3 class="font-semibold">Riwayat Transaksi Terakhir</h3>
                    </div>

                    @if($riwayat->isEmpty())
                        <div class="p-4 text-sm text-gray-700 bg-gray-100 rounded-lg">
                            Belum ada riwayat transaksi pembayaran.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-green-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pasien</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Bayar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Metode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Cetak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $pembayaran)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pembayaran->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pembayaran->rekamMedis->pasien->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pembayaran->metode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.pembayaran.print', $pembayaran->id) }}" class="text-blue-600 hover:text-blue-800">Cetak</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>