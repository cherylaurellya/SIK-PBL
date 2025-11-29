<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dokter Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.dokter.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama Dokter</label>
                            <input type="text" name="name" id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email Login</label>
                            <input type="email" name="email" id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- NO STR --}}
                        <div class="mb-4">
                            <label for="no_str" class="block font-medium text-sm text-gray-700">Nomor STR</label>
                            <input type="text" name="no_str" id="no_str" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Spesialisasi --}}
                        <div class="mb-4">
                            <label for="spesialisasi" class="block font-medium text-sm text-gray-700">Spesialisasi</label>
                            <select name="spesialisasi" id="spesialisasi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                <option value="Umum">Umum</option>
                                <option value="Gigi">Gigi</option>
                                <option value="Anak">Anak</option>
                                <option value="Kandungan">Kandungan</option>
                                <option value="Penyakit Dalam">Penyakit Dalam</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dokter.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Dokter
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>