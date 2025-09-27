@extends('layout')

@section('title', 'Detail User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user"></i> Detail User</h1>
    <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi User</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->user_id }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nama:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->name }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>No. Telepon:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }} fs-6">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Alamat:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->address }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Dibuat:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Diperbarui:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                            <i class="fas fa-trash"></i> Hapus User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection