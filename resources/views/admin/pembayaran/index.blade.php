<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

           
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-l-4 border-red-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tagihan Belum Lunas (Menunggu Pembayaran)
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Periksa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                
                                @forelse($tagihanBelumLunas ?? [] as $tagihan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $tagihan->pasien->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $tagihan->pasien->user->nik ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tagihan->dokter->user->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ Str::limit($tagihan->diagnosa, 30) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            {{-- Form Proses Pembayaran --}}
                                            @php
                                                // Cek role untuk menentukan route update
                                                $routeUpdate = Auth::user()->role == 'admin' 
                                                    ? route('admin.pembayaran.update', $tagihan->id) 
                                                    : route('perawat.pembayaran.update', $tagihan->id);
                                            @endphp

                                            <form action="{{ $routeUpdate }}" method="POST" class="inline-block" onsubmit="return confirm('Proses pembayaran untuk pasien ini?');">
                                                @csrf
                                                @method('PUT')
                                                
                                                {{-- Input Nominal (Bisa dibuat otomatis atau manual) --}}
                                                <div class="flex items-center justify-end gap-2">
                                                    <input type="number" name="total_biaya" placeholder="Input Biaya (Rp)" class="text-sm border-gray-300 rounded-md shadow-sm w-32" required min="0">
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm shadow">
                                                        Proses Bayar
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">
                                            Tidak ada tagihan yang belum lunas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Riwayat Pembayaran Terakhir
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cetak</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riwayatPembayaran ?? [] as $pembayaran)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                            #{{ $pembayaran->no_transaksi ?? $pembayaran->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pembayaran->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $pembayaran->rekamMedis->pasien->user->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                            Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Lunas
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @php
                                                $routeCetak = Auth::user()->role == 'admin' 
                                                    ? route('admin.pembayaran.cetak', $pembayaran->id) 
                                                    : route('perawat.pembayaran.cetak', $pembayaran->id);
                                            @endphp
                                            <a href="{{ $routeCetak }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 flex justify-end items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Struk
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada riwayat pembayaran.
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