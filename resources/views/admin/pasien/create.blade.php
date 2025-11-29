<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.pasien.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- NIK --}}
                            <div>
                                <label for="nik" class="block font-medium text-sm text-gray-700">NIK (KTP)</label>
                                <input type="text" name="nik" id="nik" maxlength="16" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="block font-medium text-sm text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                             {{-- Password --}}
                             <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                                <input type="password" name="password" id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mt-4">
                            <label for="alamat" class="block font-medium text-sm text-gray-700">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.pasien.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Pasien
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>