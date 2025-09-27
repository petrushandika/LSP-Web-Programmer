@extends('layout')

@section('title', 'Detail Katalog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye"></i> Detail Katalog</h1>
    <div>
        <a href="{{ route('catalogues.edit', $catalogue) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('catalogues.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Katalog</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID Katalog:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $catalogue->catalogue_id }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Judul:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $catalogue->title }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Harga:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="h5 text-success">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Pemilik:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $catalogue->user->name }}
                        <small class="text-muted">({{ $catalogue->user->email }})</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $catalogue->status_publish == 'Y' ? 'success' : 'secondary' }} fs-6">
                            {{ $catalogue->status_publish == 'Y' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Deskripsi:</strong>
                    </div>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ $catalogue->description }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Dibuat:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $catalogue->created_at->format('d M Y H:i') }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Diperbarui:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $catalogue->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orders related to this catalogue -->
        @if($catalogue->orders->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Pesanan Terkait</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pemesan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($catalogue->orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Gambar Katalog</h5>
            </div>
            <div class="card-body text-center">
                @if($catalogue->image)
                    <img src="{{ asset('storage/' . $catalogue->image) }}" 
                         alt="{{ $catalogue->title }}" 
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
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('catalogues.edit', $catalogue) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Katalog
                    </a>
                    <form action="{{ route('catalogues.destroy', $catalogue) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin ingin menghapus katalog ini? Semua pesanan terkait juga akan terhapus.')">
                            <i class="fas fa-trash"></i> Hapus Katalog
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection