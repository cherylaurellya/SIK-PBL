@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Dokter</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.dokter.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap (+ Gelar)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Spesialisasi</label>
                        <select name="spesialisasi" class="form-select">
                            <option value="Umum">Umum</option>
                            <option value="Gigi">Gigi</option>
                            <option value="Anak">Anak</option>
                            <option value="Penyakit Dalam">Penyakit Dalam</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nomor STR</label>
                        <input type="text" name="no_str" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection