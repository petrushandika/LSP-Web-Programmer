@extends('layout')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-cogs"></i> Pengaturan Sistem</h1>
    <a href="{{ route('settings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pengaturan
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($settings->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Perusahaan</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->setting_id }}</td>
                            <td>
                                <strong>{{ $setting->company_name }}</strong>
                            </td>
                            <td>
                                @if($setting->email)
                                    <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($setting->phone_number)
                                    <a href="tel:{{ $setting->phone_number }}">{{ $setting->phone_number }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($setting->address)
                                    {{ Str::limit($setting->address, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('settings.show', $setting) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('settings.edit', $setting) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus pengaturan ini?')">
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
                {{ $settings->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data pengaturan</h5>
                <p class="text-muted">Tambahkan pengaturan sistem untuk mengkonfigurasi aplikasi</p>
                <a href="{{ route('settings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pengaturan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- System Information Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Pengaturan</h6>
                        <h4>{{ $settings->total() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Dengan Email</h6>
                        <h4>{{ $settings->whereNotNull('email')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Dengan Telepon</h6>
                        <h4>{{ $settings->whereNotNull('phone_number')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-phone fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Dengan Alamat</h6>
                        <h4>{{ $settings->whereNotNull('address')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
@if($settings->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Pengaturan Terbaru</h6>
                @php $latestSetting = $settings->sortByDesc('created_at')->first(); @endphp
                @if($latestSetting)
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                        <div>
                            <strong>{{ $latestSetting->company_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $latestSetting->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            <a href="{{ route('settings.show', $latestSetting) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-md-6">
                <h6>Pengaturan Terakhir Diperbarui</h6>
                @php $recentSetting = $settings->sortByDesc('updated_at')->first(); @endphp
                @if($recentSetting)
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                        <div>
                            <strong>{{ $recentSetting->company_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $recentSetting->updated_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            <a href="{{ route('settings.edit', $recentSetting) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection