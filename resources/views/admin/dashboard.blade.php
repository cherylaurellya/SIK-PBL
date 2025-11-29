@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Ringkas -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="mb-0 text-gray-800">Dashboard</h2>
            <p class="text-muted small mb-0">Selamat Datang, {{ Auth::user()->name }}</p>
        </div>
        <div class="text-end">
            <span class="badge bg-secondary">{{ date('d M Y') }}</span>
        </div>
    </div>

    <!-- Baris Menu Utama (4 Kolom - Lebih Kompak) -->
    <div class="row g-3 mb-4">
        <!-- 1. Pasien -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Pasien</div>
                        <div class="fs-5 fw-bold">Data Pasien</div>
                    </div>
                    <i class="fas fa-user-injured fa-2x opacity-50"></i>
                </div>
                <a href="{{ route('admin.pasien.index') }}" class="card-footer text-white clearfix small z-1 text-decoration-none d-flex align-items-center justify-content-between bg-primary border-top border-white border-opacity-25">
                    <span>Kelola Data</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>

        <!-- 2. Dokter -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Dokter</div>
                        <div class="fs-5 fw-bold">Data Dokter</div>
                    </div>
                    <i class="fas fa-user-md fa-2x opacity-50"></i>
                </div>
                <a href="{{ route('admin.dokter.index') }}" class="card-footer text-white clearfix small z-1 text-decoration-none d-flex align-items-center justify-content-between bg-success border-top border-white border-opacity-25">
                    <span>Kelola Data</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>

        <!-- 3. Perawat -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Perawat</div>
                        <div class="fs-5 fw-bold">Data Perawat</div>
                    </div>
                    <i class="fas fa-user-nurse fa-2x opacity-50"></i>
                </div>
                <a href="{{ route('admin.perawat.index') }}" class="card-footer text-white clearfix small z-1 text-decoration-none d-flex align-items-center justify-content-between bg-info border-top border-white border-opacity-25">
                    <span>Kelola Data</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>

        <!-- 4. Jadwal -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-dark h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-dark-50 text-uppercase fw-bold">Jadwal</div>
                        <div class="fs-5 fw-bold">Jadwal Praktik</div>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-25"></i>
                </div>
                <a href="{{ route('admin.jadwal-dokter.index') }}" class="card-footer text-dark clearfix small z-1 text-decoration-none d-flex align-items-center justify-content-between bg-warning border-top border-dark border-opacity-10">
                    <span>Atur Jadwal</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Baris Info & Aksi Cepat -->
    <div class="row g-3">
        <!-- Info Klinik -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="fw-bold text-secondary"><i class="fas fa-info-circle me-1"></i> Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">
                        Sistem Informasi Klinik ini mengintegrasikan data Pasien, Dokter, dan Perawat secara realtime. 
                        Pastikan data master (Dokter & Jadwal) sudah terisi sebelum melakukan transaksi pendaftaran pasien.
                    </p>
                    <div class="alert alert-light border small mb-0">
                        <strong>Status Server:</strong> <span class="text-success">● Online</span> | <strong>Database:</strong> Terhubung
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="fw-bold text-secondary"><i class="fas fa-bolt me-1"></i> Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pasien.create') }}" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-user-plus me-2"></i> Tambah Pasien Baru
                        </a>
                        <a href="{{ route('admin.dokter.create') }}" class="btn btn-outline-success btn-sm text-start">
                            <i class="fas fa-user-md me-2"></i> Tambah Dokter Baru
                        </a>
                        <a href="{{ route('admin.jadwal-dokter.create') }}" class="btn btn-outline-warning text-dark btn-sm text-start">
                            <i class="fas fa-calendar-plus me-2"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection