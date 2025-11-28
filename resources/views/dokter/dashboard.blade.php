@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Halo, Dr. {{ Auth::user()->name }}</h2>
            <p class="text-muted">Selamat bertugas.</p>
        </div>
        <div>
            <span class="badge bg-primary p-2"><i class="fas fa-calendar-alt me-1"></i> {{ date('d M Y') }}</span>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-dark h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Pasien Menunggu</h6>
                        <h2 class="mb-0 fw-bold">{{ $jumlahAntrian }}</h2>
                    </div>
                    <i class="fas fa-user-clock fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Selesai Diperiksa</h6>
                        <h2 class="mb-0 fw-bold">{{ $jumlahSelesai }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Jadwal Praktik</h6>
                        <p class="mb-0 fw-bold">08:00 - 14:00 WIB</p>
                    </div>
                    <i class="fas fa-business-time fa-3x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pasien -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-ul me-2 text-primary"></i>Daftar Pasien Hari Ini</h5>
            <a href="{{ route('dokter.rekam-medis.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Periksa Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Nama Pasien</th>
                            <th>NIK</th>
                            <th>Status</th>
                            <th class="text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 1. Tampilkan Pasien yang BELUM diperiksa (Antrian) --}}
                        @forelse($antrian as $pasien)
                        <tr>
                            <td class="px-4 fw-bold">{{ $pasien->user->name }}</td>
                            <td>{{ $pasien->nik }}</td>
                            <td><span class="badge bg-warning text-dark rounded-pill">Menunggu</span></td>
                            <td class="text-end px-4">
                                <a href="{{ route('dokter.rekam-medis.create', ['pasien_id' => $pasien->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-stethoscope me-1"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                            {{-- Jika tidak ada antrian --}}
                        @endforelse

                        {{-- 2. Tampilkan Pasien yang SUDAH diperiksa (Selesai) --}}
                        @foreach($sudahDiperiksa as $rekam)
                        <tr class="table-success bg-opacity-10">
                            <td class="px-4">
                                <span class="fw-bold">{{ $rekam->pasien->user->name }}</span>
                                <br>
                                <small class="text-muted">Diagnosa: {{ Str::limit($rekam->diagnosis, 20) }}</small>
                            </td>
                            <td>{{ $rekam->pasien->nik }}</td>
                            <td><span class="badge bg-success rounded-pill">Selesai</span></td>
                            <td class="text-end px-4">
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-check me-1"></i> Sudah
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($antrian->isEmpty() && $sudahDiperiksa->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i> Belum ada data pasien hari ini.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection