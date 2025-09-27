@extends('layout')

@section('title', 'Daftar Katalog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-book"></i> Daftar Katalog</h1>
    <a href="{{ route('catalogues.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Katalog
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($catalogues->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Harga</th>
                            <th>Pemilik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($catalogues as $catalogue)
                        <tr>
                            <td>{{ $catalogue->catalogue_id }}</td>
                            <td>
                                @if($catalogue->image)
                                    <img src="{{ asset('storage/' . $catalogue->image) }}" 
                                         alt="{{ $catalogue->title }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $catalogue->title }}</td>
                            <td>Rp {{ number_format($catalogue->price, 0, ',', '.') }}</td>
                            <td>{{ $catalogue->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $catalogue->status_publish == 'Y' ? 'success' : 'secondary' }}">
                                    {{ $catalogue->status_publish == 'Y' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('catalogues.show', $catalogue) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('catalogues.edit', $catalogue) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('catalogues.destroy', $catalogue) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus katalog ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $catalogues->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data katalog</h5>
                <a href="{{ route('catalogues.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Katalog Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection