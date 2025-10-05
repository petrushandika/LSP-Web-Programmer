@extends('admin.layout')

@section('title', 'Catalogue Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Catalogue Management</h1>
            <a href="{{ route('catalogues.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Catalogue
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.catalogues') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by package name or description...">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="Y" {{ request('status') == 'Y' ? 'selected' : '' }}>Published</option>
                            <option value="N" {{ request('status') == 'N' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.catalogues') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Catalogues Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Package Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($catalogues as $index => $catalogue)
                                <tr>
                                    <td>{{ $catalogues->firstItem() + $index }}</td>
                                    <td>
                                        @if($catalogue->image_url)
                                            <img src="{{ $catalogue->image_url }}" alt="{{ $catalogue->package_name }}" 
                                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 4px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $catalogue->package_name }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $catalogue->catalogue_id }}</small>
                                    </td>
                                    <td>
                                        <div class="description-cell">
                                            {{ Str::limit($catalogue->description, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @if($catalogue->status_publish == 'Y')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $catalogue->user->name ?? 'Unknown' }}
                                        <br>
                                        <small class="text-muted">{{ $catalogue->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('catalogues.show', $catalogue->catalogue_id) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('catalogues.edit', $catalogue->catalogue_id) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteCatalogue({{ $catalogue->catalogue_id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No catalogues found</p>
                                        <a href="{{ route('catalogues.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add First Catalogue
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($catalogues->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <p class="text-muted mb-0">
                                Showing {{ $catalogues->firstItem() }} to {{ $catalogues->lastItem() }} 
                                of {{ $catalogues->total() }} results
                            </p>
                        </div>
                        <div>
                            {{ $catalogues->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this catalogue? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .description-cell {
        max-width: 200px;
        word-wrap: break-word;
    }
    
    .img-thumbnail {
        border: 1px solid #dee2e6;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin-right: 0;
            margin-bottom: 2px;
        }
        
        .description-cell {
            max-width: 150px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function deleteCatalogue(id) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/catalogues/${id}`;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endsection