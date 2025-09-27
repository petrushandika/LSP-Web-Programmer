@extends('layout')

@section('title', 'Detail Pengaturan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye"></i> Detail Pengaturan</h1>
    <div>
        <a href="{{ route('settings.edit', $setting) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Perusahaan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID Pengaturan:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-primary fs-6">{{ $setting->setting_id }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nama Perusahaan:</strong>
                    </div>
                    <div class="col-sm-9">
                        <h5 class="text-primary mb-0">{{ $setting->company_name }}</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($setting->email)
                            <a href="mailto:{{ $setting->email }}" class="text-decoration-none">
                                <i class="fas fa-envelope"></i> {{ $setting->email }}
                            </a>
                        @else
                            <span class="text-muted">Tidak tersedia</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>No. Telepon:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($setting->phone_number)
                            <a href="tel:{{ $setting->phone_number }}" class="text-decoration-none">
                                <i class="fas fa-phone"></i> {{ $setting->phone_number }}
                            </a>
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
                        @if($setting->address)
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt mt-1 me-2"></i>
                                <span>{{ $setting->address }}</span>
                            </div>
                        @else
                            <span class="text-muted">Tidak tersedia</span>
                        @endif
                    </div>
                </div>
                
                @if($setting->description)
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Deskripsi:</strong>
                    </div>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ $setting->description }}</p>
                    </div>
                </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Dibuat:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $setting->created_at->format('d M Y H:i') }}
                        <small class="text-muted">({{ $setting->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Diperbarui:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $setting->updated_at->format('d M Y H:i') }}
                        <small class="text-muted">({{ $setting->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Information Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kontak</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Email</h6>
                                @if($setting->email)
                                    <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Telepon</h6>
                                @if($setting->phone_number)
                                    <a href="tel:{{ $setting->phone_number }}">{{ $setting->phone_number }}</a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Alamat</h6>
                                @if($setting->address)
                                    <p class="mb-0">{{ $setting->address }}</p>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Actions Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('settings.edit', $setting) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Pengaturan
                    </a>
                    
                    <form action="{{ route('settings.destroy', $setting) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin ingin menghapus pengaturan ini?')">
                            <i class="fas fa-trash"></i> Hapus Pengaturan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- System Info Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Status Konfigurasi</small>
                    <div class="progress mt-1" style="height: 8px;">
                        @php
                            $completeness = 0;
                            if($setting->company_name) $completeness += 25;
                            if($setting->email) $completeness += 25;
                            if($setting->phone_number) $completeness += 25;
                            if($setting->address) $completeness += 25;
                        @endphp
                        <div class="progress-bar bg-{{ $completeness == 100 ? 'success' : ($completeness >= 75 ? 'warning' : 'danger') }}" 
                             style="width: {{ $completeness }}%"></div>
                    </div>
                    <small class="text-muted">{{ $completeness }}% lengkap</small>
                </div>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="mb-0">{{ $completeness }}%</h6>
                            <small class="text-muted">Kelengkapan</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-0">{{ $setting->created_at->diffInDays() }}</h6>
                        <small class="text-muted">Hari</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Contact Card -->
        @if($setting->email || $setting->phone_number)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Kontak Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($setting->email)
                        <a href="mailto:{{ $setting->email }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope"></i> Kirim Email
                        </a>
                    @endif
                    
                    @if($setting->phone_number)
                        <a href="tel:{{ $setting->phone_number }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-phone"></i> Telepon
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection