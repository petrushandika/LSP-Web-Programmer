@extends('layout')

@section('title', 'Tambah Pengaturan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus-circle"></i> Tambah Pengaturan</h1>
    <a href="{{ route('settings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('settings.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                               id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama perusahaan atau organisasi</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Email resmi perusahaan</div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nomor telepon yang dapat dihubungi (10-15 digit)</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Alamat lengkap perusahaan</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Deskripsi singkat tentang perusahaan atau layanan (opsional)</div>
            </div>
            
            <!-- Preview Card -->
            <div class="card bg-light mb-3" id="preview-card" style="display: none;">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-eye"></i> Preview Pengaturan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama Perusahaan:</strong> <span id="preview-company">-</span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="preview-email">-</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>No. Telepon:</strong> <span id="preview-phone">-</span></p>
                            <p class="mb-1"><strong>Alamat:</strong> <span id="preview-address">-</span></p>
                        </div>
                    </div>
                    <div class="mt-2" id="preview-description-container" style="display: none;">
                        <p class="mb-0"><strong>Deskripsi:</strong></p>
                        <p class="text-muted mb-0" id="preview-description">-</p>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('settings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const companyInput = document.getElementById('company_name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone_number');
        const addressInput = document.getElementById('address');
        const descriptionInput = document.getElementById('description');
        const previewCard = document.getElementById('preview-card');
        
        function updatePreview() {
            const company = companyInput.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();
            const address = addressInput.value.trim();
            const description = descriptionInput.value.trim();
            
            if (company || email || phone || address) {
                document.getElementById('preview-company').textContent = company || '-';
                document.getElementById('preview-email').textContent = email || '-';
                document.getElementById('preview-phone').textContent = phone || '-';
                document.getElementById('preview-address').textContent = address || '-';
                
                const descContainer = document.getElementById('preview-description-container');
                if (description) {
                    document.getElementById('preview-description').textContent = description;
                    descContainer.style.display = 'block';
                } else {
                    descContainer.style.display = 'none';
                }
                
                previewCard.style.display = 'block';
            } else {
                previewCard.style.display = 'none';
            }
        }
        
        // Add event listeners
        companyInput.addEventListener('input', updatePreview);
        emailInput.addEventListener('input', updatePreview);
        phoneInput.addEventListener('input', updatePreview);
        addressInput.addEventListener('input', updatePreview);
        descriptionInput.addEventListener('input', updatePreview);
        
        // Phone number formatting
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            if (value.length > 15) {
                value = value.substring(0, 15); // Limit to 15 digits
            }
            e.target.value = value;
            updatePreview();
        });
        
        // Initial preview update
        updatePreview();
    });
</script>
@endsection