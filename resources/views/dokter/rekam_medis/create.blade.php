@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i>Form Pemeriksaan Medis</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokter.rekam-medis.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Pasien</label>
                            <select name="pasien_id" class="form-select" required>
                                <option value="">-- Pilih Pasien dari Antrian --</option>
                                @foreach($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->user->name }} - (NIK: {{ $pasien->nik }})</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Keluhan (Anamnesa)</label>
                            <textarea name="keluhan" class="form-control" rows="2" placeholder="Apa yang dirasakan pasien?" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diagnosa Dokter</label>
                            <textarea name="diagnosa" class="form-control" rows="2" placeholder="Hasil diagnosa penyakit..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindakan Medis</label>
                            <input type="text" name="tindakan" class="form-control" placeholder="Misal: Cek tensi, Nebulizer, Jahit luka..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-success"><i class="fas fa-pills me-1"></i> Resep Obat</label>
                            <textarea name="resep_obat" class="form-control border-success" rows="3" placeholder="Tuliskan nama obat dan dosis (Cth: Paracetamol 3x1)"></textarea>
                            <div class="form-text">Resep ini akan diteruskan ke bagian Farmasi/Pembayaran.</div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Rekam Medis</button>
                            <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection