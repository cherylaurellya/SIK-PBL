@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1>Area Pasien</h1>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}. Semoga lekas sembuh!</p>
        </div>
        <div>
            <span class="badge bg-success p-2"><i class="fas fa-user-check me-1"></i> Akun Pasien Aktif</span>
        </div>
    </div>

    <div class="row">
        <!-- Kartu Info Status (Opsional) -->
        <div class="col-md-12 mb-4">
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Info Pembayaran & Obat:</strong>
                    Silakan tunjukkan resep digital di bawah ini ke bagian Farmasi/Kasir untuk pengambilan obat.
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Berobat (Fitur Utama: Rekam Medis & Resep) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Berobat Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Tanggal</th>
                            <th>Dokter Pemeriksa</th>
                            <th>Diagnosa</th>
                            <th>Resep Obat</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $rekam)
                        <tr>
                            <td class="text-center">{{ \Carbon\Carbon::parse($rekam->tanggal)->format('d M Y, H:i') }}</td>
                            <td>Dr. {{ $rekam->dokter->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $rekam->diagnosis }}</span>
                                <br>
                                <small class="text-muted">{{ Str::limit($rekam->keluhan, 30) }}</small>
                            </td>
                            <td class="bg-light">
                                @if($rekam->resep_obat)
                                    <i class="fas fa-pills text-success me-1"></i> <strong>{{ $rekam->resep_obat }}</strong>
                                @else
                                    <span class="text-muted">- Tidak ada resep -</span>
                                @endif
                            </td>
                            <td>{{ $rekam->tindakan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-file-medical fa-3x mb-3"></i><br>
                                Belum ada riwayat pemeriksaan medis.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection