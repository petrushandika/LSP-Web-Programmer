@extends('layout')

@section('title', 'Edit Pengaturan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit"></i> Edit Pengaturan</h1>
    <div>
        <a href="{{ route('settings.show', $setting) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Lihat
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
                <h5 class="card-title mb-0">Form Edit Pengaturan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update', $setting) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="company_name" class="form-label">
                                <i class="fas fa-building"></i> Nama Perusahaan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('company_name') is-invalid @enderror" 
                                   id="company_name" 
                                   name="company_name" 
                                   value="{{ old('company_name', $setting->company_name) }}" 
                                   required
                                   placeholder="Masukkan nama perusahaan">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $setting->email) }}"
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">
                                <i class="fas fa-phone"></i> No. Telepon
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $setting->phone_number) }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap">{{ old('address', $setting->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-info-circle"></i> Deskripsi
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Deskripsi tentang perusahaan (opsional)">{{ old('description', $setting->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui Pengaturan
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('settings.show', $setting) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('settings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Current Information Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Saat Ini</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Nama Perusahaan</small>
                    <div class="fw-bold">{{ $setting->company_name }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Email</small>
                    <div>{{ $setting->email ?: 'Tidak tersedia' }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">No. Telepon</small>
                    <div>{{ $setting->phone_number ?: 'Tidak tersedia' }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Alamat</small>
                    <div>{{ $setting->address ?: 'Tidak tersedia' }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Terakhir Diperbarui</small>
                    <div>{{ $setting->updated_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Preview Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview Real-time</h5>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 bg-light">
                    <div class="mb-2">
                        <strong id="preview-company-name">{{ $setting->company_name }}</strong>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-envelope text-muted"></i>
                        <span id="preview-email">{{ $setting->email ?: 'Email tidak tersedia' }}</span>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-phone text-muted"></i>
                        <span id="preview-phone">{{ $setting->phone_number ?: 'Telepon tidak tersedia' }}</span>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-map-marker-alt text-muted"></i>
                        <span id="preview-address">{{ $setting->address ?: 'Alamat tidak tersedia' }}</span>
                    </div>
                    @if($setting->description)
                    <div class="mt-2 pt-2 border-top">
                        <small id="preview-description">{{ $setting->description }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Help Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Bantuan</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <i class="fas fa-info-circle text-info"></i>
                    <small>Nama perusahaan wajib diisi</small>
                </div>
                <div class="mb-2">
                    <i class="fas fa-envelope text-primary"></i>
                    <small>Email harus dalam format yang valid</small>
                </div>
                <div class="mb-2">
                    <i class="fas fa-phone text-success"></i>
                    <small>Nomor telepon sebaiknya dimulai dengan 08</small>
                </div>
                <div class="mb-2">
                    <i class="fas fa-map-marker-alt text-warning"></i>
                    <small>Alamat lengkap membantu pelanggan</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time preview functionality
    const companyNameInput = document.getElementById('company_name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone_number');
    const addressInput = document.getElementById('address');
    const descriptionInput = document.getElementById('description');
    
    const previewCompanyName = document.getElementById('preview-company-name');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    const previewAddress = document.getElementById('preview-address');
    const previewDescription = document.getElementById('preview-description');
    
    companyNameInput.addEventListener('input', function() {
        previewCompanyName.textContent = this.value || '{{ $setting->company_name }}';
    });
    
    emailInput.addEventListener('input', function() {
        previewEmail.textContent = this.value || 'Email tidak tersedia';
    });
    
    phoneInput.addEventListener('input', function() {
        previewPhone.textContent = this.value || 'Telepon tidak tersedia';
    });
    
    addressInput.addEventListener('input', function() {
        previewAddress.textContent = this.value || 'Alamat tidak tersedia';
    });
    
    if (descriptionInput && previewDescription) {
        descriptionInput.addEventListener('input', function() {
            previewDescription.textContent = this.value || '{{ $setting->description }}';
        });
    }
});
</script>
@endsection