<x-app-layout>

<x-slot name="header">

<h2 class="font-semibold text-xl text-gray-800 leading-tight">

{{ __('Dashboard Dokter') }}

</h2>

</x-slot>



<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">



            <div class="mb-6">

                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h1>

                <p class="text-gray-600">Hari ini: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>

            </div>



            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

               

                {{-- Card Antrian --}}

                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg shadow-sm flex justify-between items-center">

                    <div>

                        <div class="text-sm font-bold text-blue-500 uppercase">Pasien Menunggu</div>

                        {{-- FIX: Mengganti $jumlahAntrian menjadi $totalAntrian --}}

                        <div class="text-3xl font-extrabold text-blue-700 mt-1">{{ $totalAntrian }}</div>

                    </div>

                    <div class="p-3 bg-blue-200 rounded-full text-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />

                        </svg>

                    </div>

                </div>



                {{-- Card Pasien Ditangani --}}

                <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-lg shadow-sm flex justify-between items-center">

                    <div>

                        <div class="text-sm font-bold text-green-500 uppercase">Total Pasien Ditangani</div>

                        <div class="text-3xl font-extrabold text-green-700 mt-1">{{ $totalPasienDitangani }}</div>

                    </div>

                    <div class="p-3 bg-green-200 rounded-full text-green-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />

                        </svg>

                    </div>

                </div>



                {{-- Card Jadwal Hari Ini --}}

                <div class="bg-purple-50 border-l-4 border-purple-500 p-6 rounded-r-lg shadow-sm">

                    <div class="text-sm font-bold text-purple-500 uppercase mb-2">Jadwal Hari Ini ({{ $jadwalHariIni->hari ?? '---' }})</div>

                    @if ($jadwalHariIni)

                        <div class="text-xl font-extrabold text-purple-700">{{ $jadwalHariIni->jam_mulai }} - {{ $jadwalHariIni->jam_selesai }}</div>

                        <div class="text-sm text-purple-500 mt-1">Status:

                            @if((int)$jadwalHariIni->status === 1)

                                <span class="font-bold text-green-600">AKTIF</span>

                            @else

                                <span class="font-bold text-red-600">LIBUR</span>

                            @endif

                        </div>

                    @else

                        <div class="text-lg text-purple-700 mt-1">Tidak ada jadwal hari ini.</div>

                    @endif

                </div>

            </div>



            {{-- Daftar Antrian Pasien --}}

            <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">

                <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Antrian ({{ $totalAntrian }})</h3>

                <div class="overflow-x-auto">

                    @if ($antrianPasien->isEmpty())

                        <p class="text-gray-500">Tidak ada pasien dalam antrian saat ini.</p>

                    @else

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-200">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Pasien</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>

                                </tr>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($antrianPasien as $pasien)

                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pasien->user->name }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            {{-- FIX PENTING: Mengganti tautan URL relatif yang salah menjadi fungsi route() yang benar --}}

                                            <a href="{{ route('dokter.rekam-medis.create', $pasien->id) }}" class="text-blue-600 hover:text-blue-900">Mulai Periksa</a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @endif

                </div>

            </div>



        </div>

    </div>

</div>





</x-app-layout>