<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Praktik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.jadwal-dokter.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Dokter --}}
                        <div class="mb-4">
                            <label for="dokter_id" class="block font-medium text-sm text-gray-700">Pilih Dokter</label>
                            <select name="dokter_id" id="dokter_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                @foreach(\App\Models\Dokter::with('user')->get() as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->user->name }} - {{ $dokter->spesialisasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Hari --}}
                        <div class="mb-4">
                            <label for="hari" class="block font-medium text-sm text-gray-700">Hari Praktik</label>
                            <select name="hari" id="hari" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Jam Mulai --}}
                            <div class="mb-4">
                                <label for="jam_mulai" class="block font-medium text-sm text-gray-700">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Jam Selesai --}}
                            <div class="mb-4">
                                <label for="jam_selesai" class="block font-medium text-sm text-gray-700">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                <option value="1">Aktif</option>
                                <option value="0">Libur</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.jadwal-dokter.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Jadwal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>