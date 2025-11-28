@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Dokter</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $dokter->user->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $dokter->user->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Spesialisasi</label>
                        <input type="text" name="spesialisasi" class="form-control" value="{{ $dokter->spesialisasi }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nomor STR</label>
                        <input type="text" name="no_str" class="form-control" value="{{ $dokter->no_str }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </div>
    </div>
</div>
@endsection