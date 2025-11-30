<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Rekam Medis Lengkap') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Medis Pasien: {{ $user->name }}</h1>

                    @if($riwayatMedis->isEmpty())
                        <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg">
                            Anda belum memiliki riwayat pemeriksaan.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter Pemeriksa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resep Obat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($riwayatMedis as $rekam)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{-- Menggunakan Carbon::parse() sebagai fallback jika Model tidak memiliki casting date --}}
                                                <div class="text-sm font-medium text-gray-900">{{ Carbon\Carbon::parse($rekam->tanggal)->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ Carbon\Carbon::parse($rekam->tanggal)->format('H:i') }} WIB</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $rekam->dokter->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden">
                                                {{ $rekam->keluhan }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $rekam->diagnosis }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $rekam->tindakan }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden">
                                                {{ $rekam->resep_obat }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('pasien.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-50">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>