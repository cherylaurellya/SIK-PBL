<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Perawat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Menampilkan Pesan Error Validasi --}}
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

                    {{-- FIX: Action harus ke admin.perawat.update dan menggunakan variabel $perawat --}}
                    <form action="{{ route('admin.perawat.update', $perawat->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $perawat->user->name) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email Login</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $perawat->user->email) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- NOMOR STR --}}
                            <div>
                                {{-- FIX: Menggunakan nama field yang benar sesuai Controller: 'nomor_str' --}}
                                <label for="nomor_str" class="block font-medium text-sm text-gray-700">Nomor STR</label>
                                <input type="text" name="nomor_str" id="nomor_str" value="{{ old('nomor_str', $perawat->nomor_str) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Password (Opsional) --}}
                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Password Baru (Opsional)</label>
                                <input type="password" name="password" id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Biarkan kosong jika tidak diganti">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.perawat.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>