@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1>Dashboard Perawat</h1>
            <p class="text-muted mb-0">Halo, Ners {{ Auth::user()->name }}. Data ini terhubung langsung dengan Dokter.</p>
        </div>
        <div>
            <span class="badge bg-info text-dark p-2"><i class="fas fa-calendar-alt me-1"></i> {{ date('d M Y') }}</span>
        </div>
    </div>

    <!-- Ringkasan Statistik Realtime -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-0">{{ $totalAntrian }}</h2>
                        <div class="small">Pasien Menunggu Dokter</div>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-0">{{ $totalSelesai }}</h2>
                        <div class="small">Pasien Selesai Diperiksa</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-warning text-dark mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-0">{{ $dokterPraktek }}</h2>
                        <div class="small">Dokter Standby</div>
                    </div>
                    <i class="fas fa-user-md fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tabel Antrian Realtime -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <i class="fas fa-list-alt me-1 text-primary"></i>
                    Status Antrian Pasien (Realtime)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 1. LIST PASIEN MENUNGGU (Belum diperiksa dokter) --}}
                                @foreach($antrian as $pasien)
                                <tr>
                                    <td class="fw-bold">{{ $pasien->user->name }}</td>
                                    <td>{{ $pasien->nik }}</td>
                                    <td><span class="badge bg-warning text-dark">Menunggu Dokter</span></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-bullhorn"></i> Panggil</button>
                                    </td>
                                </tr>
                                @endforeach

                                {{-- 2. LIST PASIEN SELESAI (Sudah diperiksa dokter hari ini) --}}
                                @foreach($selesai as $rekam)
                                <tr class="table-success opacity-75">
                                    <td>{{ $rekam->pasien->user->name }}</td>
                                    <td>{{ $rekam->pasien->nik }}</td>
                                    <td>
                                        <span class="badge bg-success">Selesai</span>
                                        <small class="d-block text-muted">Dr. {{ $rekam->dokter->user->name }}</small>
                                    </td>
                                    <td>
                                        <span class="text-success"><i class="fas fa-check"></i> Tuntas</span>
                                    </td>
                                </tr>
                                @endforeach

                                @if($antrian->isEmpty() && $selesai->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data pasien hari ini.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <i class="fas fa-cogs me-1"></i>
                    Tugas Perawat
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <p class="small text-muted">Jika ada pasien baru datang, daftarkan disini agar masuk ke antrian Dokter.</p>
                        <!-- Ini tombol kuncinya: Menambah Pasien Baru -->
                        <a href="{{ route('admin.pasien.create') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-user-plus me-2"></i> 1. Daftarkan Pasien Baru
                        </a>
                        <div class="alert alert-info small mt-2">
                            <i class="fas fa-info-circle"></i> Setelah didaftarkan, pasien akan otomatis muncul di tabel antrian (kiri) dan di <strong>Dashboard Dokter</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection