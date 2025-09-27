@extends('layout')

@section('title', 'Edit Katalog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit"></i> Edit Katalog</h1>
    <div>
        <a href="{{ route('catalogues.show', $catalogue) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Lihat
        </a>
        <a href="{{ route('catalogues.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('catalogues.update', $catalogue) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $catalogue->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pemilik <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Pilih Pemilik</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}" 
                                        {{ old('user_id', $catalogue->user_id) == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $catalogue->price) }}" 
                                   min="0" step="1000" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status_publish" class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_publish') is-invalid @enderror" id="status_publish" name="status_publish" required>
                            <option value="">Pilih Status</option>
                            <option value="Y" {{ old('status_publish', $catalogue->status_publish) == 'Y' ? 'selected' : '' }}>Published</option>
                            <option value="N" {{ old('status_publish', $catalogue->status_publish) == 'N' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status_publish')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" required>{{ old('description', $catalogue->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Baru</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    @if($catalogue->image)
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $catalogue->image) }}" 
                                 alt="{{ $catalogue->title }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 150px; max-height: 150px;">
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                            <label class="form-check-label text-danger" for="remove_image">
                                Hapus gambar saat ini
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('catalogues.show', $catalogue) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview new image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if doesn't exist
                let preview = document.getElementById('new-image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'new-image-preview';
                    preview.className = 'mt-2';
                    preview.innerHTML = '<label class="form-label">Preview Gambar Baru</label><br><img class="img-thumbnail" style="max-width: 150px; max-height: 150px;">';
                    document.getElementById('image').parentNode.appendChild(preview);
                }
                preview.querySelector('img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Handle remove image checkbox
    document.getElementById('remove_image')?.addEventListener('change', function(e) {
        const currentImageDiv = this.closest('.col-md-6');
        const img = currentImageDiv.querySelector('img');
        if (this.checked) {
            img.style.opacity = '0.3';
            img.style.filter = 'grayscale(100%)';
        } else {
            img.style.opacity = '1';
            img.style.filter = 'none';
        }
    });
</script>
@endsection