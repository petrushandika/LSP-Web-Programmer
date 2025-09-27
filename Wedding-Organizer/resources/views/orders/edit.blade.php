@extends('layout')

@section('title', 'Edit Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit"></i> Edit Pesanan</h1>
    <div>
        <a href="{{ route('orders.show', $order) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Lihat
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pemesan <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Pilih Pemesan</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}" 
                                        {{ old('user_id', $order->user_id) == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="catalogue_id" class="form-label">Katalog <span class="text-danger">*</span></label>
                        <select class="form-select @error('catalogue_id') is-invalid @enderror" id="catalogue_id" name="catalogue_id" required>
                            <option value="">Pilih Katalog</option>
                            @foreach($catalogues as $catalogue)
                                <option value="{{ $catalogue->catalogue_id }}" 
                                        data-price="{{ $catalogue->price }}"
                                        {{ old('catalogue_id', $order->catalogue_id) == $catalogue->catalogue_id ? 'selected' : '' }}>
                                    {{ $catalogue->title }} - Rp {{ number_format($catalogue->price, 0, ',', '.') }}
                                    ({{ $catalogue->user->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('catalogue_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="requested" {{ old('status', $order->status) == 'requested' ? 'selected' : '' }}>Requested</option>
                            <option value="approved" {{ old('status', $order->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Harga Katalog</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" id="price_display" readonly>
                        </div>
                        <div class="form-text">Harga akan otomatis terisi setelah memilih katalog</div>
                    </div>
                </div>
            </div>
            
            <!-- Current Order Info -->
            <div class="card bg-info text-white mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-info-circle"></i> Informasi Pesanan Saat Ini</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>ID Pesanan:</strong> {{ $order->order_id }}</p>
                            <p class="mb-1"><strong>Dibuat:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Terakhir Diperbarui:</strong> {{ $order->updated_at->format('d M Y H:i') }}</p>
                            <p class="mb-1"><strong>Status Saat Ini:</strong> 
                                <span class="badge bg-{{ $order->status == 'approved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary Card -->
            <div class="card bg-light mb-3" id="order-summary">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-receipt"></i> Ringkasan Perubahan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Pemesan:</strong> <span id="summary-user">{{ $order->user->name }}</span></p>
                            <p class="mb-1"><strong>Katalog:</strong> <span id="summary-catalogue">{{ $order->catalogue->title }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Harga:</strong> <span id="summary-price" class="text-success fw-bold">Rp {{ number_format($order->catalogue->price, 0, ',', '.') }}</span></p>
                            <p class="mb-1"><strong>Status:</strong> <span id="summary-status">
                                <span class="badge bg-{{ $order->status == 'approved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">
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
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('user_id');
        const catalogueSelect = document.getElementById('catalogue_id');
        const statusSelect = document.getElementById('status');
        const priceDisplay = document.getElementById('price_display');
        
        function updatePriceDisplay() {
            const selectedOption = catalogueSelect.options[catalogueSelect.selectedIndex];
            if (selectedOption.value) {
                const price = selectedOption.getAttribute('data-price');
                priceDisplay.value = new Intl.NumberFormat('id-ID').format(price);
            } else {
                priceDisplay.value = '';
            }
            updateSummary();
        }
        
        function updateSummary() {
            const userOption = userSelect.options[userSelect.selectedIndex];
            const catalogueOption = catalogueSelect.options[catalogueSelect.selectedIndex];
            const statusOption = statusSelect.options[statusSelect.selectedIndex];
            
            if (userOption.value) {
                document.getElementById('summary-user').textContent = userOption.text;
            }
            
            if (catalogueOption.value) {
                document.getElementById('summary-catalogue').textContent = catalogueOption.text.split(' - ')[0];
                document.getElementById('summary-price').textContent = 'Rp ' + priceDisplay.value;
            }
            
            if (statusOption.value) {
                document.getElementById('summary-status').innerHTML = 
                    '<span class="badge bg-' + (statusOption.value === 'approved' ? 'success' : 'warning') + '">' + 
                    statusOption.text + '</span>';
            }
        }
        
        catalogueSelect.addEventListener('change', updatePriceDisplay);
        userSelect.addEventListener('change', updateSummary);
        statusSelect.addEventListener('change', updateSummary);
        
        // Initialize on page load
        updatePriceDisplay();
    });
</script>
@endsection