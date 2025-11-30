<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg->px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Gagal Menyimpan!</strong>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pembayaran Tagihan Pasien</h1>

                    {{-- Data Rekam Medis --}}
                    <div class="mb-6 p-4 border rounded-lg bg-indigo-50">
                        <h3 class="text-lg font-bold text-indigo-800 mb-2">Rincian Layanan</h3>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            {{-- $rekamMedis sudah dipastikan ada dari Controller --}}
                            <p><strong>Pasien:</strong> {{ $rekamMedis->pasien->user->name ?? 'N/A' }}</p>
                            <p><strong>Dokter:</strong> {{ $rekamMedis->dokter->user->name ?? 'N/A' }}</p>
                            <p><strong>Tanggal RM:</strong> {{ $rekamMedis->tanggal->format('d M Y') }}</p>
                            <p><strong>Diagnosis:</strong> <span class="font-bold">{{ $rekamMedis->diagnosis }}</span></p>
                        </div>
                    </div>

                    {{-- Form Pembayaran --}}
                    <form method="POST" action="{{ route(Auth::user()->role === 'admin' ? 'admin.pembayaran.store' : 'perawat.pembayaran.store') }}" class="mt-8">
                        @csrf
                        
                        <input type="hidden" name="rekam_medis_id" value="{{ $rekamMedis->id }}">

                        {{-- Tabel Tagihan --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">Detail Tagihan</h3>
                            <table class="min-w-full divide-y divide-gray-200 border rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- ASUMSI: Tagihan terdiri dari Biaya Jasa Dokter dan Biaya Obat --}}
                                    
                                    @php
                                        // Contoh biaya tetap. Harusnya diambil dari database atau dihitung
                                        $biayaJasa = 50000;
                                        $biayaObat = 25000; // Placeholder
                                        $totalTagihan = $biayaJasa + $biayaObat;
                                    @endphp

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jasa Dokter ({{ $rekamMedis->dokter->spesialisasi ?? 'Umum' }})</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">Rp {{ number_format($biayaJasa, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Biaya Obat & Administrasi</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">Rp {{ number_format($biayaObat, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-gray-900">TOTAL TAGIHAN</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-extrabold text-gray-900">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- FIX PENTING 1: Input name harus sesuai validasi controller --}}
                            <input type="hidden" name="total_biaya" value="{{ $totalTagihan }}"> 
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="mb-6">
                            <label for="metode_pembayaran" class="block font-medium text-sm text-gray-700">Metode Pembayaran</label>
                            {{-- FIX PENTING 2: Select name harus sesuai validasi controller --}}
                            <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Debit">Debit</option>
                            </select>
                        </div>
                        
                        {{-- Uang Diterima (Opsional, untuk hitung kembalian) --}}
                        <div class="mb-6">
                            <label for="uang_diterima" class="block font-medium text-sm text-gray-700">Uang Diterima (Opsional)</label>
                            <input type="text" name="uang_diterima" id="uang_diterima" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Masukkan jumlah uang yang diterima (misal: 100000)">
                        </div>

                        <div class="flex justify-end pt-4 border-t">
                            <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.pembayaran.index' : 'perawat.pembayaran.index') }}" class="btn btn-secondary mr-3 text-gray-600 hover:text-gray-900">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>