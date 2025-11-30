<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Buat Rekam Medis Baru') }}
</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                {{-- Menampilkan Pesan Error Validasi dari Controller --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <ul class="list-disc ml-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach {{-- FIX SINTAKS BLADE DI SINI --}}
                        </ul>
                    </div>
                @endif

                <h3 class="text-lg font-bold mb-4 border-b pb-2">Data Pasien: {{ $pasien->user->name }} (ID: {{ $pasien->id }})</h3>
                <p class="mb-4 text-gray-600">
                    **Tanggal Pemeriksaan:** {{ \Carbon\Carbon::now()->format('d M Y') }}
                    <br>
                    **Dokter Pemeriksa:** {{ $dokter->user->name }}
                </p>

                <form method="POST" action="{{ route('dokter.rekam-medis.store') }}" class="space-y-6">
                    @csrf

                    <!-- Hidden Input Pasien ID -->
                    <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                    <!-- Dokter ID diambil otomatis di Controller dari Auth::user()->dokter->id -->

                    <!-- Keluhan Utama -->
                    <div>
                        <label for="keluhan" class="block font-medium text-sm text-gray-700">Keluhan Utama</label>
                        <textarea id="keluhan" name="keluhan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Diagnosa (Disimpan sebagai 'diagnosis' di Controller) -->
                    <div>
                        <label for="diagnosa" class="block font-medium text-sm text-gray-700">Diagnosis (ICD-10)</label>
                        <input id="diagnosa" name="diagnosa" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('diagnosa') }}" required>
                        @error('diagnosa')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tindakan/Penatalaksanaan -->
                    <div>
                        <label for="tindakan" class="block font-medium text-sm text-gray-700">Tindakan / Penatalaksanaan</label>
                        <textarea id="tindakan" name="tindakan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('tindakan') }}</textarea>
                        @error('tindakan')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resep Obat -->
                    <div>
                        <label for="resep_obat" class="block font-medium text-sm text-gray-700">Resep Obat (Tuliskan nama obat, dosis, dan aturan pakai)</label>
                        <textarea id="resep_obat" name="resep_obat" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contoh: Paracetamol 500mg, 3x sehari setelah makan" >{{ old('resep_obat') }}</textarea>
                        @error('resep_obat')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end pt-4 border-t mt-6">
                        <a href="{{ route('dokter.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Simpan Rekam Medis
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


</x-app-layout>