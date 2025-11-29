@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Perawat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Perawat</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-user-nurse me-1"></i> Daftar Perawat</div>
            <a href="{{ route('admin.perawat.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Perawat
            </a>
        </div>
        <div class="card-body">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Perawat</th>
                        <th>Email</th>
                        <th>Nomor STR</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perawats as $idx => $p)
                    <tr>
                        <td>{{ $idx+1 }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->user->email }}</td>
                        <td>{{ $p->nomor_str }}</td>
                        <td>
                            <a href="{{ route('admin.perawat.edit', $p->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.perawat.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus perawat ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection