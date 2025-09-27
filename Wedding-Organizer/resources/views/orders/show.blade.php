@extends('layout')

@section('title', 'Detail Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye"></i> Detail Pesanan</h1>
    <div>
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID Pesanan:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-primary fs-6">{{ $order->order_id }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $order->status == 'approved' ? 'success' : 'warning' }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tanggal Pesanan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $order->created_at->format('d M Y H:i') }}
                        <small class="text-muted">({{ $order->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Terakhir Diperbarui:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $order->updated_at->format('d M Y H:i') }}
                        <small class="text-muted">({{ $order->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pemesan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nama:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $order->user->name }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>No. Telepon:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($order->user->phone_number)
                            <a href="tel:{{ $order->user->phone_number }}">{{ $order->user->phone_number }}</a>
                        @else
                            <span class="text-muted">Tidak tersedia</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Alamat:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($order->user->address)
                            {{ $order->user->address }}
                        @else
                            <span class="text-muted">Tidak tersedia</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $order->user->role == 'admin' ? 'danger' : 'info' }}">
                            {{ ucfirst($order->user->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Catalogue Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Katalog</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Judul:</strong>
                    </div>
                    <div class="col-sm-9">
                        <a href="{{ route('catalogues.show', $order->catalogue) }}">{{ $order->catalogue->title }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Harga:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="h5 text-success">Rp {{ number_format($order->catalogue->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Pemilik Katalog:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $order->catalogue->user->name }}
                        <small class="text-muted">({{ $order->catalogue->user->email }})</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Status Publikasi:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $order->catalogue->status_publish == 'Y' ? 'success' : 'secondary' }}">
                            {{ $order->catalogue->status_publish == 'Y' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Deskripsi:</strong>
                    </div>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ $order->catalogue->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Catalogue Image -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Gambar Katalog</h5>
            </div>
            <div class="card-body text-center">
                @if($order->catalogue->image)
                    <img src="{{ asset('storage/' . $order->catalogue->image) }}" 
                         alt="{{ $order->catalogue->title }}" 
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 300px;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                         style="height: 200px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Order Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($order->status == 'requested')
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                            <input type="hidden" name="catalogue_id" value="{{ $order->catalogue_id }}">
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Yakin ingin menyetujui pesanan ini?')">
                                <i class="fas fa-check"></i> Setujui Pesanan
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Pesanan
                    </a>
                    
                    <form action="{{ route('orders.destroy', $order) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                            <i class="fas fa-trash"></i> Hapus Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Tautan Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.show', $order->user) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user"></i> Lihat Profil Pemesan
                    </a>
                    <a href="{{ route('catalogues.show', $order->catalogue) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-book"></i> Lihat Detail Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection