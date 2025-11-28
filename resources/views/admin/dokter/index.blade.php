@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Dokter</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Dokter</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-user-md me-1"></i> Daftar Dokter</div>
            <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Dokter
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>No. STR</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokters as $idx => $dr)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $dr->user->name ?? '-' }}</td>
                            <td>{{ $dr->spesialisasi }}</td>
                            <td>{{ $dr->no_str }}</td>
                            <td>
                                <a href="{{ route('admin.dokter.edit', $dr->id) }}" class="btn btn-warning btn-sm text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.dokter.destroy', $dr->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokter ini?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data dokter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection