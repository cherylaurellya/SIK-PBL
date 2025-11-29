<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Dokter --}}
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $dokter->user->name) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $dokter->user->email) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- GANTI DARI SIP KE NO_STR --}}
                        <div class="mb-4">
                            <label for="no_str" class="block font-medium text-sm text-gray-700">Nomor STR</label>
                            <input type="text" name="no_str" id="no_str" value="{{ old('no_str', $dokter->no_str) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            @error('no_str')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- GANTI DARI SPESIALIS KE SPESIALISASI --}}
                        <div class="mb-4">
                            <label for="spesialisasi" class="block font-medium text-sm text-gray-700">Spesialisasi</label>
                            <select name="spesialisasi" id="spesialisasi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                <option value="Umum" {{ old('spesialisasi', $dokter->spesialisasi) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                <option value="Gigi" {{ old('spesialisasi', $dokter->spesialisasi) == 'Gigi' ? 'selected' : '' }}>Gigi</option>
                                <option value="Anak" {{ old('spesialisasi', $dokter->spesialisasi) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                <option value="Kandungan" {{ old('spesialisasi', $dokter->spesialisasi) == 'Kandungan' ? 'selected' : '' }}>Kandungan</option>
                                <option value="Penyakit Dalam" {{ old('spesialisasi', $dokter->spesialisasi) == 'Penyakit Dalam' ? 'selected' : '' }}>Penyakit Dalam</option>
                            </select>
                            @error('spesialisasi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password (Opsional) --}}
                        <div class="mb-6">
                            <label for="password" class="block font-medium text-sm text-gray-700">Password Baru (Opsional)</label>
                            <input type="password" name="password" id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dokter.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>