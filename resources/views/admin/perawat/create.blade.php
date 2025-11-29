@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Perawat Baru</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.perawat.index') }}">Manajemen Perawat</a></li>
        <li class="breadcrumb-item active">Tambah Baru</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-nurse me-1"></i> Form Data Perawat
        </div>
        <div class="card-body">
            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.perawat.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Ners Siti Aminah" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Email (Untuk Login)</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email@klinik.com" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 8 karakter">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nomor_str" class="form-label fw-bold">Nomor STR (Surat Tanda Registrasi)</label>
                        <input type="text" class="form-control" id="nomor_str" name="nomor_str" value="{{ old('nomor_str') }}" placeholder="Nomor STR Perawat" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin.perawat.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection