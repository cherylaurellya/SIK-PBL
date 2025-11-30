<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Perawat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Menampilkan Pesan Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Whoops! Ada masalah dengan inputan Anda.</strong>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.perawat.store') }}">
                        @csrf
                        
                        {{-- Nama Perawat --}}
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Nama Perawat</label>
                            <input id="name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                        </div>

                        {{-- Email Login --}}
                        <div class="mt-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email Login</label>
                            <input id="email" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                        </div>

                        {{-- NOMOR STR / NIP PEGAWAI (Field yang hilang) --}}
                        <div class="mt-4">
                            <label for="nomor_str" class="block font-medium text-sm text-gray-700">Nomor STR / NIP Pegawai</label>
                            <input id="nomor_str" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" name="nomor_str" value="{{ old('nomor_str') }}" required placeholder="Masukkan Nomor STR atau NIP" />
                        </div>
                        
                        {{-- Password --}}
                        <div class="mt-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                            <input id="password" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="password" name="password" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.perawat.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Simpan Perawat') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>